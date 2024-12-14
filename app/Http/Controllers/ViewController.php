<?php

namespace App\Http\Controllers;

use App\Http\Requests\ViewsStatsRequest;
use App\Models\View;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function metrics(ViewsStatsRequest $request)
    {
        $sales = [];

        $model = $request->getModel($request->get('content'));

        foreach (range(180, 0, -1) as $day) {
            $date = now()->subDays($day);

            $sum = DB::table('views')
                ->where('created_at', '>=', $date->startOfDay())
                ->where('created_at', '<=', now()->subDays($day)->endOfDay())
                ->when(! empty($model), function (Builder $query) use ($model) {
                    return $query->where('viewable_type', $model);
                })
                ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                    return $query->where('viewable_id', request()->get('fragment'));
                })
                ->count();

            $ru = DB::table('views')
                ->where('created_at', '>=', $date->startOfDay())
                ->where('created_at', '<=', now()->subDays($day)->endOfDay())
                ->where('lang', 'ru')
                ->when(! empty($model), function (Builder $query) use ($model) {
                    return $query->where('viewable_type', $model);
                })
                ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                    return $query->where('viewable_id', request()->get('fragment'));
                })
                ->count();

            $en = DB::table('views')
                ->where('created_at', '>=', $date->startOfDay())
                ->where('created_at', '<=', now()->subDays($day)->endOfDay())
                ->where('lang', 'en')
                ->when(! empty($model), function (Builder $query) use ($model) {
                    return $query->where('viewable_type', $model);
                })
                ->when(is_numeric($request->get('fragment')), function (Builder $query) {
                    return $query->where('viewable_id', request()->get('fragment'));
                })
                ->count();

            $sales[] = [
                'date' => $date->format('Y-m-d'),
                'sum' => (int) $sum,
                'ru' => (int) $ru,
                'en' => (int) $en,
            ];
        }

        return response()->json($sales);
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
