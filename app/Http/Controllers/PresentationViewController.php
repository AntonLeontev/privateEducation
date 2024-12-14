<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresentationStatsRequest;
use App\Models\PresentationView;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresentationViewController extends Controller
{
    public function index(PresentationStatsRequest $request)
    {
        [$start, $end] = $request->getPeriodDates();

        $en = DB::table('presentation_views')
            ->where('created_at', '>=', $start->startOfDay())
            ->where('created_at', '<=', $end->endOfDay())
            ->where('lang', 'en')
            ->when($request->get('content') === 'sum', function (Builder $query) {
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
            ->when($request->get('content') === 'sum', function (Builder $query) {
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
            ->when($request->get('content') === 'sum', function (Builder $query) {
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

    public function metrics(PresentationStatsRequest $request)
    {
        $sales = [];

        foreach (range(180, 0, -1) as $day) {
            $date = now()->subDays($day);

            $sum = DB::table('presentation_views')
                ->where('created_at', '>=', $date->startOfDay())
                ->where('created_at', '<=', now()->subDays($day)->endOfDay())
                ->when($request->get('content') === 'sum', function (Builder $query) {
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
                ->where('created_at', '>=', $date->startOfDay())
                ->where('created_at', '<=', now()->subDays($day)->endOfDay())
                ->where('lang', 'ru')
                ->when($request->get('content') === 'sum', function (Builder $query) {
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

            $en = DB::table('presentation_views')
                ->where('created_at', '>=', $date->startOfDay())
                ->where('created_at', '<=', now()->subDays($day)->endOfDay())
                ->where('lang', 'en')
                ->when($request->get('content') === 'sum', function (Builder $query) {
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
        PresentationView::create([
            'user_id' => auth()->id(),
            'presentation_id' => $request->get('presentation_id'),
            'is_reading' => $request->get('is_reading'),
            'is_passive' => $request->get('is_passive'),
            'lang' => $request->get('lang'),
        ]);
    }
}
