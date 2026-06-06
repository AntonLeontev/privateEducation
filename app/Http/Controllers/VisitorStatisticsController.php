<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use App\Services\PlaytimeParser;
use App\Support\Traits\WorksWithPeriods;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class VisitorStatisticsController extends Controller
{
    use WorksWithPeriods;

    private const UTM_NONE_VALUE = '__none__';

    public function __construct(private readonly PlaytimeParser $playtimeParser) {}

    public function index(Request $request): View|JsonResponse
    {
        if (! $request->ajax()) {
            return view('admin.visitor-statistics');
        }

        try {
            return response()->json($this->buildStatisticsPayload($request));
        } catch (Throwable $exception) {
            Log::channel('telegram')->warning('VisitorStatisticsController: failed to load statistics', [
                'exception' => $exception->getMessage(),
                'period' => $request->query('period'),
                'start' => $request->query('start'),
                'end' => $request->query('end'),
                'utm_source' => $request->query('utm_source'),
            ]);

            return response()->json(['message' => 'Failed to load statistics'], 500);
        }
    }

    /**
     * @return array{
     *     timelines: list<array{fragment_id: int, duration_seconds: int, active: list<array{second_index: int, total_hits: int, visits_reached: int}>, passive: list<array{second_index: int, total_hits: int, visits_reached: int}>}>,
     *     utm_breakdown: list<array{label: string, value: string, visits_count: int}>,
     *     utm_options: list<array{label: string, value: string}>,
     *     filters_applied: array{period: mixed, start: mixed, end: mixed, utm_source: ?string}
     * }
     */
    private function buildStatisticsPayload(Request $request): array
    {
        /** @var array{0: ?Carbon, 1: ?Carbon} $bounds */
        $bounds = $this->getPeriodDates();
        [$from, $to] = $bounds;

        $filtersBase = [
            'period' => $request->query('period'),
            'start' => $request->query('start'),
            'end' => $request->query('end'),
            'utm_source' => null,
        ];

        if ($from === null || $to === null) {
            return [
                'timelines' => [],
                'utm_breakdown' => [],
                'utm_options' => [],
                'filters_applied' => $filtersBase,
            ];
        }

        $fromBound = $from->copy()->startOfDay();
        $toBound = $to->copy()->endOfDay();

        $utmBreakdown = $this->queryUtmBreakdown($fromBound, $toBound);
        $allowedValues = array_map(static fn (array $row): string => $row['value'], $utmBreakdown);
        $rawUtmParam = $request->query('utm_source');
        $appliedUtm = null;
        if (is_string($rawUtmParam) && $rawUtmParam !== '' && in_array($rawUtmParam, $allowedValues, true)) {
            $appliedUtm = $rawUtmParam;
        }

        $filtersBase['utm_source'] = $appliedUtm;

        return [
            'timelines' => $this->queryAllAggregateTimelines($fromBound, $toBound, $appliedUtm),
            'utm_breakdown' => $utmBreakdown,
            'utm_options' => $this->sortUtmOptions($utmBreakdown),
            'filters_applied' => $filtersBase,
        ];
    }

    /**
     * @return list<array{label: string, value: string, visits_count: int}>
     */
    private function queryUtmBreakdown(Carbon $from, Carbon $to): array
    {
        // Subquery avoids ONLY_FULL_GROUP_BY rejecting TRIM(utm_source) vs GROUP BY expression.
        $utmNormSub = DB::table('visits')
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw("NULLIF(TRIM(utm_source), '') AS norm_key");

        $rows = DB::query()
            ->fromSub($utmNormSub, 'utm_norm')
            ->select('norm_key')
            ->selectRaw('COUNT(*) AS visits_count')
            ->groupBy('norm_key')
            ->get();

        $out = [];
        foreach ($rows as $row) {
            $normKey = $row->norm_key;
            $isNone = $normKey === null || $normKey === '';
            $out[] = [
                'label' => $isNone ? '(не указано)' : (string) $normKey,
                'value' => $isNone ? self::UTM_NONE_VALUE : (string) $normKey,
                'visits_count' => (int) $row->visits_count,
            ];
        }

        return $out;
    }

    /**
     * @param  list<array{label: string, value: string, visits_count: int}>  $breakdown
     * @return list<array{label: string, value: string}>
     */
    private function sortUtmOptions(array $breakdown): array
    {
        $noneRow = null;
        $rest = [];
        foreach ($breakdown as $row) {
            if ($row['value'] === self::UTM_NONE_VALUE) {
                $noneRow = [
                    'label' => $row['label'],
                    'value' => $row['value'],
                ];
            } else {
                $rest[] = [
                    'label' => $row['label'],
                    'value' => $row['value'],
                ];
            }
        }

        usort($rest, static function (array $a, array $b): int {
            return strcmp($a['label'], $b['label']);
        });

        $options = [];
        if ($noneRow !== null) {
            $options[] = $noneRow;
        }

        return array_merge($options, $rest);
    }

    /**
     * @return list<array{fragment_id: int, duration_seconds: int, active: list<array{second_index: int, total_hits: int, visits_reached: int}>, passive: list<array{second_index: int, total_hits: int, visits_reached: int}>}>
     */
    private function queryAllAggregateTimelines(Carbon $from, Carbon $to, ?string $appliedUtm): array
    {
        $query = DB::table('presentation_view_second_stats')
            ->join('visits', 'presentation_view_second_stats.visit_id', '=', 'visits.id')
            ->join('presentations', 'presentation_view_second_stats.presentation_id', '=', 'presentations.id')
            ->whereBetween('visits.created_at', [$from, $to])
            ->select([
                'presentations.fragment_id',
                'presentation_view_second_stats.second_index',
                'presentation_view_second_stats.is_passive',
                DB::raw('SUM(presentation_view_second_stats.hit_count) AS total_hits'),
                DB::raw('COUNT(DISTINCT presentation_view_second_stats.visit_id) AS visits_reached'),
            ])
            ->groupBy(
                'presentations.fragment_id',
                'presentation_view_second_stats.second_index',
                'presentation_view_second_stats.is_passive'
            )
            ->orderBy('presentations.fragment_id')
            ->orderBy('presentation_view_second_stats.second_index');

        if ($appliedUtm === self::UTM_NONE_VALUE) {
            $query->whereRaw("NULLIF(TRIM(visits.utm_source), '') IS NULL");
        } elseif ($appliedUtm !== null && $appliedUtm !== '') {
            $query->whereRaw("NULLIF(TRIM(visits.utm_source), '') = ?", [$appliedUtm]);
        }

        $byFragment = [];

        foreach ($query->get() as $row) {
            $fragmentId = (int) $row->fragment_id;

            if (! isset($byFragment[$fragmentId])) {
                $byFragment[$fragmentId] = [
                    'active' => [],
                    'passive' => [],
                ];
            }

            $point = [
                'second_index' => (int) $row->second_index,
                'total_hits' => (int) $row->total_hits,
                'visits_reached' => (int) $row->visits_reached,
            ];

            if ($row->is_passive) {
                $byFragment[$fragmentId]['passive'][] = $point;
            } else {
                $byFragment[$fragmentId]['active'][] = $point;
            }
        }

        if ($byFragment === []) {
            return [];
        }

        $presentations = Presentation::query()
            ->whereIn('fragment_id', array_keys($byFragment))
            ->with('media')
            ->get()
            ->keyBy('fragment_id');

        ksort($byFragment);

        $timelines = [];

        foreach ($byFragment as $fragmentId => $data) {
            $presentation = $presentations->get($fragmentId);

            $timelines[] = [
                'fragment_id' => $fragmentId,
                'duration_seconds' => $presentation !== null
                    ? $this->playtimeParser->durationForPresentation($presentation)
                    : 0,
                'active' => $data['active'],
                'passive' => $data['passive'],
            ];
        }

        return $timelines;
    }
}
