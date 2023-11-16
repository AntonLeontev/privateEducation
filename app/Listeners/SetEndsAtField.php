<?php

namespace App\Listeners;

use App\Events\SubscriptionCreating;

class SetEndsAtField
{
    public function handle(SubscriptionCreating $event): void
    {
        $event->subscription->ends_at = $event->subscription->created_at->addDays(31);
    }
}
