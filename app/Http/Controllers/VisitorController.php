<?php

namespace App\Http\Controllers;

use App\Http\Resources\VisitResource;
use App\Models\Presentation;
use App\Models\Visit;
use App\Services\PlaytimeParser;
use App\Support\Traits\WorksWithPeriods;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    use WorksWithPeriods;

    public function __construct(private readonly PlaytimeParser $playtimeParser) {}

    public function index()
    {
        if (! request()->ajax()) {
            return view('admin.visitors');
        }

        [$periodStart, $periodEnd] = $this->getPeriodDates();

        $visits = Visit::query()
            ->select('visits.*')
            ->selectRaw('ROW_NUMBER() OVER (PARTITION BY visits.visitor_id ORDER BY visits.created_at ASC, visits.id ASC) AS visit_number')
            ->where(function ($query) {
                $query->whereHas('presentationViewTimes')
                    ->orWhereHas('presentationViewSecondStats');
            })
            ->with(['visitor.user', 'visitor.country'])
            ->when($periodStart && $periodEnd, function ($query) use ($periodStart, $periodEnd) {
                $query->whereBetween('visits.created_at', [
                    $periodStart->copy()->startOfDay(),
                    $periodEnd->copy()->endOfDay(),
                ]);
            })
            ->orderByDesc('visits.created_at')
            ->orderByDesc('visits.id')
            ->cursorPaginate(50);

        $this->attachFragmentsToVisits($visits->getCollection());

        return VisitResource::collection($visits);
    }

    /**
     * @param  Collection<int, Visit>  $visits
     */
    private function attachFragmentsToVisits(Collection $visits): void
    {
        if ($visits->isEmpty()) {
            return;
        }

        $visitIds = $visits->pluck('id')->all();

        $scalarRows = DB::table('presentation_view_second_stats')
            ->select([
                'presentation_view_second_stats.visit_id',
                'presentations.fragment_id',
                'presentation_view_second_stats.is_passive',
                DB::raw('SUM(presentation_view_second_stats.hit_count) as seconds'),
            ])
            ->join('presentations', 'presentation_view_second_stats.presentation_id', '=', 'presentations.id')
            ->whereIn('presentation_view_second_stats.visit_id', $visitIds)
            ->groupBy(
                'presentation_view_second_stats.visit_id',
                'presentations.fragment_id',
                'presentation_view_second_stats.is_passive'
            )
            ->orderBy('presentation_view_second_stats.visit_id')
            ->orderBy('presentations.fragment_id')
            ->get();

        $timelineRows = DB::table('presentation_view_second_stats')
            ->select([
                'presentation_view_second_stats.visit_id',
                'presentations.fragment_id',
                'presentation_view_second_stats.second_index',
                'presentation_view_second_stats.is_passive',
                'presentation_view_second_stats.hit_count',
            ])
            ->join('presentations', 'presentation_view_second_stats.presentation_id', '=', 'presentations.id')
            ->whereIn('presentation_view_second_stats.visit_id', $visitIds)
            ->orderBy('presentation_view_second_stats.visit_id')
            ->orderBy('presentations.fragment_id')
            ->orderBy('presentation_view_second_stats.second_index')
            ->get();

        $fragmentIds = $scalarRows->pluck('fragment_id')->unique()->map(fn ($id) => (int) $id)->all();
        $durationByFragment = $this->durationSecondsByFragmentIds($fragmentIds);

        $byVisit = [];
        foreach ($scalarRows as $row) {
            $visitId = (int) $row->visit_id;
            if (! isset($byVisit[$visitId])) {
                $byVisit[$visitId] = collect();
            }
            $byVisit[$visitId]->push($row);
        }

        $timelinesByVisit = [];
        foreach ($timelineRows as $row) {
            $visitId = (int) $row->visit_id;
            $fragmentId = (int) $row->fragment_id;
            if (! isset($timelinesByVisit[$visitId][$fragmentId])) {
                $timelinesByVisit[$visitId][$fragmentId] = [
                    'active_timeline' => [],
                    'passive_timeline' => [],
                ];
            }
            $point = [
                'second_index' => (int) $row->second_index,
                'hit_count' => (int) $row->hit_count,
            ];
            if ($row->is_passive) {
                $timelinesByVisit[$visitId][$fragmentId]['passive_timeline'][] = $point;
            } else {
                $timelinesByVisit[$visitId][$fragmentId]['active_timeline'][] = $point;
            }
        }

        foreach ($visits as $visit) {
            $visitRows = $byVisit[$visit->id] ?? collect();
            $fragments = $this->rowsToFragmentMap($visitRows, $timelinesByVisit[$visit->id] ?? [], $durationByFragment);
            $visit->setAttribute('fragments', array_values($fragments));
        }
    }

    /**
     * @param  array<int, int>  $fragmentIds
     * @return array<int, int>
     */
    private function durationSecondsByFragmentIds(array $fragmentIds): array
    {
        if ($fragmentIds === []) {
            return [];
        }

        $presentations = Presentation::query()
            ->whereIn('fragment_id', $fragmentIds)
            ->with('media')
            ->get();

        $map = [];
        foreach ($presentations as $presentation) {
            $map[(int) $presentation->fragment_id] = $this->playtimeParser->durationForPresentation($presentation);
        }

        return $map;
    }

    /**
     * @param  Collection<int, object>  $rows
     * @param  array<int, array{active_timeline: list<array{second_index: int, hit_count: int}>, passive_timeline: list<array{second_index: int, hit_count: int}>}>  $timelinesByFragment
     * @param  array<int, int>  $durationByFragment
     * @return array<int, array<string, mixed>>
     */
    private function rowsToFragmentMap(Collection $rows, array $timelinesByFragment, array $durationByFragment): array
    {
        $fragments = [];

        foreach ($rows as $row) {
            $fragmentId = (int) $row->fragment_id;

            if (! isset($fragments[$fragmentId])) {
                $timeline = $timelinesByFragment[$fragmentId] ?? [
                    'active_timeline' => [],
                    'passive_timeline' => [],
                ];
                $fragments[$fragmentId] = [
                    'fragment_id' => $fragmentId,
                    'active_seconds' => 0,
                    'passive_seconds' => 0,
                    'active_timeline' => $timeline['active_timeline'],
                    'passive_timeline' => $timeline['passive_timeline'],
                    'duration_seconds' => $durationByFragment[$fragmentId] ?? 0,
                ];
            }

            if ($row->is_passive) {
                $fragments[$fragmentId]['passive_seconds'] = (int) $row->seconds;
            } else {
                $fragments[$fragmentId]['active_seconds'] = (int) $row->seconds;
            }
        }

        foreach ($timelinesByFragment as $fragmentId => $timeline) {
            if (isset($fragments[$fragmentId])) {
                continue;
            }
            $fragments[$fragmentId] = [
                'fragment_id' => (int) $fragmentId,
                'active_seconds' => 0,
                'passive_seconds' => 0,
                'active_timeline' => $timeline['active_timeline'],
                'passive_timeline' => $timeline['passive_timeline'],
                'duration_seconds' => $durationByFragment[$fragmentId] ?? 0,
            ];
        }

        return $fragments;
    }
}
