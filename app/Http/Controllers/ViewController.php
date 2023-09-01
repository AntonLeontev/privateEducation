<?php

namespace App\Http\Controllers;

use App\Http\Requests\ViewsStatsRequest;
use Illuminate\Database\Query\Builder;
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
}
