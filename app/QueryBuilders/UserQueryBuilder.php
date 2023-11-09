<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class UserQueryBuilder extends Builder
{
    public function search(): self
    {
        return $this->when(request()->filled('search'), function ($query) {
            $query->where('email', 'LIKE', '%'.request('search').'%')
                ->orWhere('name', 'LIKE', '%'.request('search').'%')
                ->when(is_numeric(request('search')), function (Builder $query) {
                    return $query->orWhere('id', (int) request()->get('search'));
                });
        });
    }

    public function fragmentOrMediaFilter(): self
    {
        return $this->when(request()->filled('media') || request()->filled('fragment'), function ($query) {
            $subscriptions = DB::table('subscriptions')
                ->select('user_id', 'subscribable_type', 'subscribable_id')
                ->when(request()->filled('media'), function ($query) {
                    $media = 'App\\Models\\'.ucfirst(request('media'));

                    $query->where('subscribable_type', $media);
                })
                ->when(request()->filled('fragment'), function ($query) {
                    $query->where('subscribable_id', request('fragment'));
                })
                ->whereColumn('subscriptions.user_id', 'users.id');

            $query->whereExists($subscriptions);
        });
    }

    public function categoryFilter(): self
    {
        return $this->when(request()->users_category === 'active', function ($query) {
            $query->whereHas('activeSubscriptions')
                ->orderByDesc('last_subscription_time');
        })
            ->when(request()->users_category === 'customers', function ($query) {
                $query->whereHas('subscriptions')
                    ->orderByDesc('last_subscription_time');
            })
            ->when(request()->users_category === 'all', function ($query) {
                $query->orderByDesc('id');
            });
    }
}
