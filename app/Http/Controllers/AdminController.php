<?php

namespace App\Http\Controllers;

use App\MoonShine\Resources\UserResource;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function custom()
    {
        $fragments = DB::table('subscriptions')
            ->select([
                'subscribable_id',
                DB::raw('SUM(price) AS sum_price'),
            ])
            ->where('created_at', '>=', now()->startOfDay())
            ->where('created_at', '<=', now()->endOfDay())
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

        return view('admin.custom', compact('fragments'));
    }

    public function users()
    {
        return view('admin.users', ['resource' => (new UserResource())]);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
