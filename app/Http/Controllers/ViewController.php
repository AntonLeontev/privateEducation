<?php

namespace App\Http\Controllers;

use App\Http\Requests\ViewsStatsRequest;
use App\Models\View;
use App\Services\AdminMetrics\DailySeriesBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ViewController extends Controller
{
    public function views(ViewsStatsRequest $request)
    {
        [$start, $end] = $request->getPeriodDates();

        $model = $request->getModel($request->get('content'));

        $en = DB::table('views')
            ->where('created_at', '>=', $start->startOfDay())
            ->where('created_at', '<=', $end->endOfDay())
            ->where('lang', 'en')
            ->when(! empty($model), function (Builder $query) use ($model) {
                return $query->where('viewable_type', $model);
            })
            ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                return $query->where('viewable_id', request()->get('fragment'));
            })
            ->count();

        $ru = DB::table('views')
            ->where('created_at', '>=', $start->startOfDay())
            ->where('created_at', '<=', $end->endOfDay())
            ->where('lang', 'ru')
            ->when(! empty($model), function (Builder $query) use ($model) {
                return $query->where('viewable_type', $model);
            })
            ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                return $query->where('viewable_id', request()->get('fragment'));
            })
            ->count();

        return response()->json(['ru' => $ru, 'en' => $en]);
    }

    public function popularFragments(ViewsStatsRequest $request)
    {
        [$start, $end] = $request->getPeriodDates();

        $model = $request->getModel($request->get('content'));

        $fragments = DB::table('views')
            ->select([
                'viewable_id',
                DB::raw('COUNT(viewable_id) AS count'),
            ])
            ->where('created_at', '>=', $start->startOfDay())
            ->where('created_at', '<=', $end->endOfDay())
            ->when(! empty($model), function (Builder $query) use ($model) {
                return $query->where('viewable_type', $model);
            })
            ->groupBy('viewable_id')
            ->orderByDesc('count')
            ->take(4)
            ->get()
            ->map(function ($el, int $key) {
                return [
                    'id' => $el->viewable_id,
                    'sum' => $el->count,
                    'position' => $key + 1,
                ];
            });

        return response()->json($fragments);
    }

    public function metrics(ViewsStatsRequest $request, DailySeriesBuilder $dailySeriesBuilder)
    {
        $start = now()->subDays(180)->startOfDay();
        $end = now()->endOfDay();
        $model = $request->getModel($request->get('content'));

        try {
            $rows = DB::table('views')
                ->selectRaw('DATE(created_at) as day')
                ->selectRaw('COUNT(*) as sum')
                ->selectRaw("SUM(CASE WHEN lang = 'ru' THEN 1 ELSE 0 END) as ru")
                ->selectRaw("SUM(CASE WHEN lang = 'en' THEN 1 ELSE 0 END) as en")
                ->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)
                ->when(! empty($model), function (Builder $query) use ($model) {
                    return $query->where('viewable_type', $model);
                })
                ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                    return $query->where('viewable_id', request()->get('fragment'));
                })
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
        } catch (Throwable $e) {
            Log::error('[ViewController.metrics] query failed', [
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
        View::create([
            'user_id' => auth()->id(),
            'viewable_id' => $request->get('viewable_id'),
            'viewable_type' => $request->get('viewable_type'),
            'lang' => $request->get('lang'),
        ]);
    }
}
