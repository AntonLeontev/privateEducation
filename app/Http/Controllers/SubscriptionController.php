<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesStatsRequest;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

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

    public function metrics(SalesStatsRequest $request)
    {
        $sales = [];

        $model = $request->getModel($request->get('content'));

        foreach (range(180, 0, -1) as $day) {
            $date = now()->subDays($day);

            $sum = DB::table('subscriptions')
                ->where('created_at', '>=', $date->startOfDay())
                ->where('created_at', '<=', now()->subDays($day)->endOfDay())
                ->when(! empty($model), function (Builder $query) use ($model) {
                    return $query->where('subscribable_type', $model);
                })
                ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                    return $query->where('subscribable_id', request()->get('fragment'));
                })
                ->sum('price');

            $ru = DB::table('subscriptions')
                ->where('created_at', '>=', $date->startOfDay())
                ->where('created_at', '<=', now()->subDays($day)->endOfDay())
                ->where('lang', 'ru')
                ->when(! empty($model), function (Builder $query) use ($model) {
                    return $query->where('subscribable_type', $model);
                })
                ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                    return $query->where('subscribable_id', request()->get('fragment'));
                })
                ->sum('price');

            $en = DB::table('subscriptions')
                ->where('created_at', '>=', $date->startOfDay())
                ->where('created_at', '<=', now()->subDays($day)->endOfDay())
                ->where('lang', 'en')
                ->when(! empty($model), function (Builder $query) use ($model) {
                    return $query->where('subscribable_type', $model);
                })
                ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                    return $query->where('subscribable_id', request()->get('fragment'));
                })
                ->sum('price');

            $sales[] = [
                'date' => $date->format('Y-m-d'),
                'sum' => (int) $sum / 100,
                'ru' => (int) $ru / 100,
                'en' => (int) $en / 100,
            ];
        }

        return response()->json($sales);
    }
}
