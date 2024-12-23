<?php

namespace App\Listeners;

use App\Enums\Currency;
use App\Events\SubscriptionCreated;
use App\Mail\SubscriptionTicket;
use Illuminate\Support\Facades\Mail;

class SendSubscriptionTicketEmail
{
    public function handle(SubscriptionCreated $event): void
    {
        if ($event->subscription->payment->currency === Currency::usd) {
            app()->setLocale('en');
        } else {
            app()->setLocale('ru');
        }

        Mail::to($event->subscription->user->email)->send(new SubscriptionTicket($event->subscription, app()->getLocale()));
    }
}
