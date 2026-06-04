<?php

namespace App\Http\Controllers;

use App\Http\Resources\VisitResource;
use App\Models\PresentationViewTime;
use App\Models\Visit;
use App\Support\Traits\WorksWithPeriods;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    use WorksWithPeriods;

    public function index()
    {
        if (! request()->ajax()) {
            return view('admin.visitors');
        }

        [$periodStart, $periodEnd] = $this->getPeriodDates();

        $visits = Visit::query()
            ->select('visits.*')
            ->selectRaw('ROW_NUMBER() OVER (PARTITION BY visits.visitor_id ORDER BY visits.created_at ASC, visits.id ASC) AS visit_number')
            ->whereHas('presentationViewTimes')
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
            $visitId = (int) $row->visit_id;
            if (! isset($byVisit[$visitId])) {
                $byVisit[$visitId] = collect();
            }
            $byVisit[$visitId]->push($row);
        }

        foreach ($visits as $visit) {
            $visitRows = $byVisit[$visit->id] ?? collect();
            $visit->setAttribute('fragments', array_values($this->rowsToFragmentMap($visitRows)));
        }
    }

    /**
     * @param  Collection<int, object>  $rows
     * @return array<int, array{fragment_id: int, active_seconds: int, passive_seconds: int}>
     */
    private function rowsToFragmentMap(Collection $rows): array
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
}
