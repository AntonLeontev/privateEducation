<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminCreateRequest;
use App\Http\Requests\AdminDeleteRequest;
use App\Http\Resources\UserResource;
use App\Models\Admin;
use App\Models\CurrencyRate;
use App\Models\Fragment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function fragments()
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

        return view('admin.fragments', compact('fragments'));
    }

    public function users()
    {
        if (! request()->ajax()) {
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
            ->search()
            ->fragmentOrMediaFilter()
            ->categoryFilter()
            ->cursorPaginate();

        $users = UserResource::collection($users);

        return $users;
    }

    public function files()
    {
        $fragments = Fragment::with(['audio', 'video', 'presentation'])->get();

        return view('admin.files', compact('fragments'));
    }

    public function prices()
    {
        $fragments = Fragment::with(['audio', 'video'])->get();

        $rub = CurrencyRate::where('name', 'EUR/RUB')->first();
        $usd = CurrencyRate::where('name', 'EUR/USD')->first();

        return view('admin.prices', compact('fragments', 'usd', 'rub'));
    }

    public function deactivation()
    {
        $fragments = Fragment::with(['audio', 'video', 'presentation'])->get();

        return view('admin.deactivation', compact('fragments'));
    }

    public function admins()
    {
        $admins = Admin::where('email', '!=', admin()->user()->email)->get();

        return view('admin.admins', compact('admins'));
    }

    public function adminStore(AdminCreateRequest $request)
    {
        return Admin::create([
            'email' => $request->validated('email'),
            'password' => bcrypt($request->validated('password')),
            'role' => $request->validated('role'),
        ]);
    }

    public function adminDestroy(Admin $admin, AdminDeleteRequest $request)
    {
        $admin->delete();
    }
}
