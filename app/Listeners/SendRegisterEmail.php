<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;

class SendRegisterEmail
{
    public function handle(UserRegistered $event)
    {
        Mail::to($event->user->email)->send(new VerifyEmail($event->user, $event->password));
    }
}
