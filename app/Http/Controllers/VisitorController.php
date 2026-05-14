<?php

namespace App\Http\Controllers;

use App\Http\Resources\VisitorResource;
use App\Models\PresentationViewTime;
use App\Models\Visit;
use App\Models\Visitor;
use App\Support\Traits\WorksWithPeriods;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class VisitorController extends Controller
{
    use WorksWithPeriods;

    public function index()
    {
        if (! request()->ajax()) {
            return view('admin.visitors');
        }

        [$periodStart, $periodEnd] = $this->getPeriodDates();

        $visitors = Visitor::query()
            ->with(['user', 'country'])
            ->when($periodStart && $periodEnd, function ($query) use ($periodStart, $periodEnd) {
                $query->whereBetween('last_visit_at', [
                    $periodStart->copy()->startOfDay(),
                    $periodEnd->copy()->endOfDay(),
                ]);
            })
            ->orderByDesc('last_visit_at')
            ->orderByDesc('id')
            ->cursorPaginate(50);

        return VisitorResource::collection($visitors);
    }

    public function show(Visitor $visitor): JsonResponse
    {
        try {
            $lifetimeFragments = $this->aggregateFragmentsForVisitor($visitor->id);
            $visitsPayload = $this->buildVisitsPayload($visitor);
            $byDayPayload = $this->buildByDayPayload($visitor->id);
        } catch (Throwable $exception) {
            Log::channel('telegram')->warning('VisitorController: failed to load visitor analytics', [
                'visitor_id' => $visitor->id,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json(['message' => 'Failed to load visitor data'], 500);
        }

        return response()->json([
            'visitor_id' => $visitor->id,
            'fragments' => array_values($lifetimeFragments),
            'visits' => $visitsPayload,
            'by_day' => $byDayPayload,
        ]);
    }

    /**
     * @return array<int, array{fragment_id: int, active_seconds: int, passive_seconds: int}>
     */
    private function aggregateFragmentsForVisitor(int $visitorId): array
    {
        $times = PresentationViewTime::query()
            ->select([
                'presentations.fragment_id',
                'presentation_view_times.is_passive',
                DB::raw('SUM(presentation_view_times.seconds) as seconds'),
            ])
            ->join('presentations', 'presentation_view_times.presentation_id', '=', 'presentations.id')
            ->where('presentation_view_times.visitor_id', '=', $visitorId, 'and')
            ->groupBy('presentations.fragment_id', 'presentation_view_times.is_passive')
            ->orderBy('presentations.fragment_id')
            ->get();

        return $this->rowsToFragmentMap($times);
    }

    /**
     * @param  Collection<int, object>  $rows
     * @return array<int, array{fragment_id: int, active_seconds: int, passive_seconds: int}>
     */
    private function rowsToFragmentMap($rows): array
    {
        $fragments = [];

        foreach ($rows as $row) {
            $fragmentId = (int) $row->fragment_id;

            if (! isset($fragments[$fragmentId])) {
                $fragments[$fragmentId] = [
                    'fragment_id' => $fragmentId,
                    'active_seconds' => 0,
                    'passive_seconds' => 0,
                ];
            }

            if ($row->is_passive) {
                $fragments[$fragmentId]['passive_seconds'] = (int) $row->seconds;
            } else {
                $fragments[$fragmentId]['active_seconds'] = (int) $row->seconds;
            }
        }

        return $fragments;
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function buildVisitsPayload(Visitor $visitor): array
    {
        $visits = Visit::query()
            ->where('visitor_id', '=', $visitor->id, 'and')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        if ($visits->isEmpty()) {
            return [];
        }

        $visitIds = $visits->pluck('id')->all();

        $rows = PresentationViewTime::query()
            ->select([
                'presentation_view_times.visit_id',
                'presentations.fragment_id',
                'presentation_view_times.is_passive',
                DB::raw('SUM(presentation_view_times.seconds) as seconds'),
            ])
            ->join('presentations', 'presentation_view_times.presentation_id', '=', 'presentations.id')
            ->whereIn('presentation_view_times.visit_id', $visitIds)
            ->groupBy('presentation_view_times.visit_id', 'presentations.fragment_id', 'presentation_view_times.is_passive')
            ->orderBy('presentation_view_times.visit_id')
            ->orderBy('presentations.fragment_id')
            ->get();

        $byVisit = [];
        foreach ($rows as $row) {
            $vid = (int) $row->visit_id;
            if (! isset($byVisit[$vid])) {
                $byVisit[$vid] = collect();
            }
            $byVisit[$vid]->push($row);
        }

        $out = [];
        foreach ($visits as $visit) {
            $visitRows = $byVisit[$visit->id] ?? collect();
            $fragments = $this->rowsToFragmentMap($visitRows);

            $out[] = [
                'id' => $visit->id,
                'started_at' => $visit->created_at?->format('d.m.Y H:i'),
                'utm' => [
                    'source' => $visit->utm_source,
                    'medium' => $visit->utm_medium,
                    'campaign' => $visit->utm_campaign,
                    'term' => $visit->utm_term,
                    'content' => $visit->utm_content,
                ],
                'referrer' => $visit->referrer,
                'fragments' => array_values($fragments),
            ];
        }

        return $out;
    }

    /**
     * @return list<array{day: string, fragments: list<array{fragment_id: int, active_seconds: int, passive_seconds: int}>}>
     */
    private function buildByDayPayload(int $visitorId): array
    {
        $rows = DB::table('presentation_view_times')
            ->join('visits', 'presentation_view_times.visit_id', '=', 'visits.id')
            ->join('presentations', 'presentation_view_times.presentation_id', '=', 'presentations.id')
            ->where('visits.visitor_id', '=', $visitorId)
            ->select([
                DB::raw('DATE(visits.created_at) as day'),
                'presentations.fragment_id',
                DB::raw('SUM(CASE WHEN presentation_view_times.is_passive = 0 THEN presentation_view_times.seconds ELSE 0 END) as active_seconds'),
                DB::raw('SUM(CASE WHEN presentation_view_times.is_passive = 1 THEN presentation_view_times.seconds ELSE 0 END) as passive_seconds'),
            ])
            ->groupBy(DB::raw('DATE(visits.created_at)'), 'presentations.fragment_id')
            ->orderBy('day')
            ->orderBy('presentations.fragment_id')
            ->get();

        $byDay = [];
        foreach ($rows as $row) {
            $day = (string) $row->day;
            if (! isset($byDay[$day])) {
                $byDay[$day] = [];
            }
            $fid = (int) $row->fragment_id;
            $byDay[$day][$fid] = [
                'fragment_id' => $fid,
                'active_seconds' => (int) $row->active_seconds,
                'passive_seconds' => (int) $row->passive_seconds,
            ];
        }

        $payload = [];
        foreach ($byDay as $day => $fragments) {
            $payload[] = [
                'day' => $day,
                'fragments' => array_values($fragments),
            ];
        }

        return $payload;
    }
}
