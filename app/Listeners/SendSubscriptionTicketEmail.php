<?php

namespace App\Listeners;

use App\Events\SubscriptionCreated;
use App\Mail\SubscriptionTicket;
use Illuminate\Support\Facades\Mail;

class SendSubscriptionTicketEmail
{
    public function handle(SubscriptionCreated $event): void
    {
        Mail::to($event->subscription->user->email)->send(new SubscriptionTicket($event->subscription, app()->getLocale()));
    }
}
