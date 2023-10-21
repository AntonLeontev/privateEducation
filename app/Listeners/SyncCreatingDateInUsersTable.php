<?php

namespace App\Listeners;

use App\Events\SubscriptionCreated;
use App\Models\User;

class SyncCreatingDateInUsersTable
{
    public function handle(SubscriptionCreated $event): void
    {
        $user = User::find($event->subscription->user_id);

        if ($user->last_subscription_time < $event->subscription->created_at) {
            $user->last_subscription_time = $event->subscription->created_at;
        }

        $user->save();
    }
}
