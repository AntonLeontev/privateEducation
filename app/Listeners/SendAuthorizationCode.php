<?php

namespace App\Listeners;

use App\Events\TwoFactorRequested;
use App\Mail\TwoFactorCodeEmail;
use Illuminate\Support\Facades\Mail;

class SendAuthorizationCode
{
    public function handle(TwoFactorRequested $event): void
    {
        if (is_null(config('auth.two_factor_email'))) {
            return;
        }

        Mail::to(config('auth.two_factor_email'))->send(new TwoFactorCodeEmail($event->admin));
    }
}
