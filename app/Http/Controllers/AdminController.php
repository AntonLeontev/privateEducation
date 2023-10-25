<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Fragment;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function users(Request $request)
    {
        if (! $request->ajax()) {
            $total = User::count();
            $buyers = User::whereHas('subscriptions')->count();
            $active = User::whereHas('activeSubscriptions')->count();

            return view('admin.users', compact('total', 'buyers', 'active'));
        }

        $users = User::query()
            ->select(['id', 'email', 'last_subscription_time', 'created_at'])
            ->with(['lastSubscriptions', 'presentationViews', 'views'])
            ->withCount(['activeSubscriptions', 'subscriptions'])
            ->withSum('activeSubscriptions', 'price')
            ->withSum('subscriptions', 'price')
            ->when($request->users_category === 'active', function ($query) {
                $query->whereHas('activeSubscriptions')
                    ->orderByDesc('last_subscription_time');
            })
            ->when($request->users_category === 'customers', function ($query) {
                $query->whereHas('subscriptions')
                    ->orderByDesc('last_subscription_time');
            })
            ->when($request->users_category === 'all', function ($query) {
                $query->orderByDesc('id');
            })
            ->cursorPaginate();

        $users = UserResource::collection($users);

        return $users;

    }

    public function files()
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

        return view('admin.files', compact('fragments'));
    }

    public function prices()
    {
        $fragments = Fragment::with(['audio', 'video'])->get();
        //TODO currency rates
        $rates = ['usd' => 1.12, 'rub' => 107.3];

        return view('admin.prices', compact('fragments', 'rates'));
    }

    public function deactivation()
    {
        $fragments = Fragment::with(['audio', 'video'])->get();

        return view('admin.deactivation', compact('fragments'));
    }
}
