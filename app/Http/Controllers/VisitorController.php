<?php

namespace App\Http\Controllers;

use App\Http\Resources\VisitorResource;
use App\Models\PresentationViewTime;
use App\Models\Visitor;
use App\Support\Traits\WorksWithPeriods;
use Illuminate\Http\JsonResponse;
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
            $times = PresentationViewTime::query()
                ->select([
                    'presentations.fragment_id',
                    'presentation_view_times.is_passive',
                    DB::raw('SUM(presentation_view_times.seconds) as seconds'),
                ])
                ->join('presentations', 'presentation_view_times.presentation_id', '=', 'presentations.id')
                ->where('presentation_view_times.visitor_id', '=', $visitor->id, 'and')
                ->groupBy('presentations.fragment_id', 'presentation_view_times.is_passive')
                ->orderBy('presentations.fragment_id')
                ->get();
        } catch (Throwable $exception) {
            Log::channel('telegram')->warning('VisitorController: failed to load view times', [
                'visitor_id' => $visitor->id,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json(['message' => 'Failed to load visitor data'], 500);
        }

        $fragments = [];

        foreach ($times as $row) {
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

        return response()->json([
            'visitor_id' => $visitor->id,
            'fragments' => array_values($fragments),
        ]);
    }
}
