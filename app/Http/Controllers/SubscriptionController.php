<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesStatsRequest;
use App\Services\AdminMetrics\DailySeriesBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class SubscriptionController extends Controller
{
    public function sales(SalesStatsRequest $request)
    {
        [$start, $end] = $request->getPeriodDates();

        $model = $request->getModel($request->get('content'));

        $en = DB::table('subscriptions')
            ->where('created_at', '>=', $start->startOfDay())
            ->where('created_at', '<=', $end->endOfDay())
            ->where('lang', 'en')
            ->when(! empty($model), function (Builder $query) use ($model) {
                return $query->where('subscribable_type', $model);
            })
            ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                return $query->where('subscribable_id', request()->get('fragment'));
            })
            ->sum('price');

        $ru = DB::table('subscriptions')
            ->where('created_at', '>=', $start->startOfDay())
            ->where('created_at', '<=', $end->endOfDay())
            ->where('lang', 'ru')
            ->when(! empty($model), function (Builder $query) use ($model) {
                return $query->where('subscribable_type', $model);
            })
            ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                return $query->where('subscribable_id', request()->get('fragment'));
            })
            ->sum('price');

        return response()->json(['ru' => $ru / 100, 'en' => $en / 100]);
    }

    public function popularFragments(SalesStatsRequest $request)
    {
        [$start, $end] = $request->getPeriodDates();

        $model = $request->getModel($request->get('content'));

        $fragments = DB::table('subscriptions')
            ->select([
                'subscribable_id',
                DB::raw('SUM(price) AS sum_price'),
            ])
            ->where('created_at', '>=', $start->startOfDay())
            ->where('created_at', '<=', $end->endOfDay())
            ->when(! empty($model), function (Builder $query) use ($model) {
                return $query->where('subscribable_type', $model);
            })
            ->groupBy('subscribable_id')
            ->orderByDesc('sum_price')
            ->take(4)
            ->get()
            ->map(function ($el, int $key) {
                return [
                    'id' => $el->subscribable_id,
                    'sum' => $el->sum_price / 100,
                    'position' => $key + 1,
                ];
            });

        return response()->json($fragments);
    }

    public function metrics(SalesStatsRequest $request, DailySeriesBuilder $dailySeriesBuilder)
    {
        $start = now()->subDays(180)->startOfDay();
        $end = now()->endOfDay();
        $model = $request->getModel($request->get('content'));

        try {
            $rows = DB::table('subscriptions')
                ->selectRaw('DATE(created_at) as day')
                ->selectRaw('SUM(price) as sum')
                ->selectRaw("SUM(CASE WHEN lang = 'ru' THEN price ELSE 0 END) as ru")
                ->selectRaw("SUM(CASE WHEN lang = 'en' THEN price ELSE 0 END) as en")
                ->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)
                ->when(! empty($model), function (Builder $query) use ($model) {
                    return $query->where('subscribable_type', $model);
                })
                ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                    return $query->where('subscribable_id', request()->get('fragment'));
                })
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
        } catch (Throwable $e) {
            Log::error('[SubscriptionController.metrics] query failed', [
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }

        $byDate = [];
        foreach ($rows as $row) {
            $byDate[(string) $row->day] = [
                'sum' => (int) $row->sum / 100,
                'ru' => (int) $row->ru / 100,
                'en' => (int) $row->en / 100,
            ];
        }

        return response()->json($dailySeriesBuilder->build($byDate, $start, $end));
    }

    public function geoSales(): JsonResponse
    {
        $countries = DB::table('subscriptions')
            ->selectRaw('country_code, SUM(price) AS sum')
            ->whereNotNull('country_code')
            ->groupBy('country_code')
            ->get()
            ->map(function ($el) {
                return ['id' => $el->country_code, 'value' => $el->sum / 100];
            });

        $ru = DB::table('subscriptions')
            ->selectRaw('region_code, SUM(price) AS sum')
            ->where('country_code', 'RU')
            ->whereNotNull('region_code')
            ->groupBy('region_code')
            ->get()
            ->map(function ($el) {
                return ['id' => $el->region_code, 'value' => $el->sum / 100];
            });

        $us = DB::table('subscriptions')
            ->selectRaw('region_code, SUM(price) AS sum')
            ->where('country_code', 'US')
            ->whereNotNull('region_code')
            ->groupBy('region_code')
            ->get()
            ->map(function ($el) {
                return ['id' => $el->region_code, 'value' => $el->sum / 100];
            });

        return response()->json(compact('countries', 'ru', 'us'));
    }
}
