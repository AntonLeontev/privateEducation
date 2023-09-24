<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
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
        $usersLastSubs = DB::table('subscriptions')
            ->select('subscriptions.user_id', DB::raw('MAX(subscriptions.created_at) AS last_sub'))
            ->groupBy('subscriptions.user_id')
            ->orderByDesc('last_sub')
            ->simplePaginate(15)
            ->withQueryString();

        $lastSubsCollection = collect($usersLastSubs->items());

        $subs = Subscription::query()
            ->whereIn('user_id', $lastSubsCollection->pluck('user_id')->toArray())
            ->orderByDesc('created_at')
            ->get();

        $users = User::query()
            ->whereIn('id', $lastSubsCollection->pluck('user_id')->toArray())
            ->with(['views', 'presentationViews'])
            ->withCount('activeSubscriptions')
            ->withCount('subscriptions')
            ->withSum('subscriptions', 'price')
            ->get()
            ->map(function (User $user) use ($lastSubsCollection, $subs) {
                $user->last_sub = $lastSubsCollection->where('user_id', $user->id)->first()->last_sub;
                $user->subscriptions_sum_price /= 100;
                $user->last_sub = Carbon::parse($user->last_sub);

                $fragments = collect();
                $userSubs = $subs->where('user_id', $user->id);

                foreach ($userSubs as $sub) {
                    $key = $sub->subscribable_id.'.'.$sub->subscribable_type;

                    if (! $fragments->has($sub->subscribable_id.'.presentation')) {
                        $fragments->put($sub->subscribable_id.'.presentation', [
                            'views' => $user->presentationViews
                                ->where('presentation_id', $sub->subscribable_id)
                                ->where('is_reading', false)
                                ->count(),
                            'readings' => $user->presentationViews
                                ->where('presentation_id', $sub->subscribable_id)
                                ->where('is_reading', true)
                                ->count(),
                        ]);
                    }

                    if ($fragments->has($key)) {
                        continue;
                    }

                    $fragments->put($key, [
                        'created_at' => $sub->created_at,
                        'ends_at' => $sub->ends_at,
                        'sum_price' => $userSubs
                            ->where('subscribable_id', $sub->subscribable_id)
                            ->where('subscribable_type', $sub->subscribable_type)
                            ->sum('price'),
                        'views' => $user->views
                            ->where('viewable_id', $sub->subscribable_id)
                            ->where('viewable_type', $sub->subscribable_type)
                            ->count(),
                    ]);
                }

                $user->fragments = $fragments->undot();

                return $user;
            })
            ->sortByDesc('last_sub');

        $total = User::count();
        $active = User::whereHas('subscriptions')->count();
        $inactive = $total - $active;

        return view('admin.users', [
            'users' => $users,
            'paginator' => $usersLastSubs,
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
        ]);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
