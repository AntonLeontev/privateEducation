<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresentationStatsRequest;
use App\Models\PresentationView;
use App\Services\AdminMetrics\DailySeriesBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PresentationViewController extends Controller
{
    public function index(PresentationStatsRequest $request)
    {
        [$start, $end] = $request->getPeriodDates();

        $en = DB::table('presentation_views')
            ->where('created_at', '>=', $start->startOfDay())
            ->where('created_at', '<=', $end->endOfDay())
            ->where('lang', 'en')
            ->when($request->get('content') !== 'passive', function (Builder $query) {
                return $query->where('is_passive', false);
            })
            ->when($request->get('content') === 'passive', function (Builder $query) {
                return $query->where('is_passive', true);
            })
            ->when($request->get('content') === 'audio', function (Builder $query) {
                return $query->where('is_reading', true);
            })
            ->when($request->get('content') === 'video', function (Builder $query) {
                return $query->where('is_reading', false);
            })
            ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                return $query->where('presentation_id', request()->get('fragment'));
            })
            ->count();

        $ru = DB::table('presentation_views')
            ->where('created_at', '>=', $start->startOfDay())
            ->where('created_at', '<=', $end->endOfDay())
            ->where('lang', 'ru')
            ->when($request->get('content') !== 'passive', function (Builder $query) {
                return $query->where('is_passive', false);
            })
            ->when($request->get('content') === 'passive', function (Builder $query) {
                return $query->where('is_passive', true);
            })
            ->when($request->get('content') === 'audio', function (Builder $query) {
                return $query->where('is_reading', true);
            })
            ->when($request->get('content') === 'video', function (Builder $query) {
                return $query->where('is_reading', false);
            })
            ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                return $query->where('presentation_id', request()->get('fragment'));
            })
            ->count();

        return response()->json(['ru' => $ru, 'en' => $en]);
    }

    public function popularFragments(PresentationStatsRequest $request)
    {
        [$start, $end] = $request->getPeriodDates();

        $fragments = DB::table('presentation_views')
            ->select([
                'presentation_id',
                DB::raw('COUNT(*) AS count'),
            ])
            ->where('created_at', '>=', $start->startOfDay())
            ->where('created_at', '<=', $end->endOfDay())
            ->when($request->get('content') !== 'passive', function (Builder $query) {
                return $query->where('is_passive', false);
            })
            ->when($request->get('content') === 'passive', function (Builder $query) {
                return $query->where('is_passive', true);
            })
            ->when($request->get('content') === 'audio', function (Builder $query) {
                return $query->where('is_reading', true);
            })
            ->when($request->get('content') === 'video', function (Builder $query) {
                return $query->where('is_reading', false);
            })
            ->groupBy('presentation_id')
            ->orderByDesc('count')
            ->take(4)
            ->get()
            ->map(function ($el, int $key) {
                return [
                    'id' => $el->presentation_id,
                    'sum' => $el->count,
                    'position' => $key + 1,
                ];
            });

        return response()->json($fragments);
    }

    public function metrics(PresentationStatsRequest $request, DailySeriesBuilder $dailySeriesBuilder)
    {
        $start = now()->subDays(180)->startOfDay();
        $end = now()->endOfDay();

        try {
            $rows = DB::table('presentation_views')
                ->selectRaw('DATE(created_at) as day')
                ->selectRaw('COUNT(*) as sum')
                ->selectRaw("SUM(CASE WHEN lang = 'ru' THEN 1 ELSE 0 END) as ru")
                ->selectRaw("SUM(CASE WHEN lang = 'en' THEN 1 ELSE 0 END) as en")
                ->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)
                ->when($request->get('content') === 'passive', function (Builder $query) {
                    return $query->where('is_passive', true);
                })
                ->when($request->get('content') !== 'passive', function (Builder $query) {
                    return $query->where('is_passive', false);
                })
                ->when($request->get('content') === 'audio', function (Builder $query) {
                    return $query->where('is_reading', true);
                })
                ->when($request->get('content') === 'video', function (Builder $query) {
                    return $query->where('is_reading', false);
                })
                ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                    return $query->where('presentation_id', request()->get('fragment'));
                })
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
        } catch (Throwable $e) {
            Log::error('[PresentationViewController.metrics] query failed', [
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }

        $byDate = [];
        foreach ($rows as $row) {
            $byDate[(string) $row->day] = [
                'sum' => (int) $row->sum,
                'ru' => (int) $row->ru,
                'en' => (int) $row->en,
            ];
        }

        return response()->json($dailySeriesBuilder->build($byDate, $start, $end));
    }

    public function store(Request $request)
    {
        PresentationView::create([
            'user_id' => auth()?->id(),
            'presentation_id' => $request->get('presentation_id'),
            'is_reading' => $request->get('is_reading'),
            'is_passive' => $request->get('is_passive'),
            'lang' => $request->get('lang'),
        ]);
    }
}
