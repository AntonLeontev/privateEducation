<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Audio;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function webhook(Request $request)
    {
        $session = Session::constructFrom($request->json('data.object'));

        if ($session->payment_status !== 'paid') {
            return;
        }

        $payment = Payment::where('external_id', $session->id)->first();
        $payment->status = PaymentStatus::success;
        $payment->confirmed_by_webhook_at = now();
        $payment->save();

        $builder = $payment->media_type === 'video' ? Video::query() : Audio::query();

        $media = $builder->where('fragment_id', $payment->fragment_id)
            ->with('subscription')
            ->first();

        $subscriptionExists = Subscription::where('user_id', $payment->user_id)
            ->where('subscribable_id', $media->id)
            ->where('subscribable_type', $media->subscribableType())
            ->exists();

        if (! $subscriptionExists) {
            $user = User::find($payment->user_id);

            Subscription::create([
                'user_id' => $payment->user_id,
                'subscribable_id' => $media->id,
                'subscribable_type' => $media->subscribableType(),
                'lang' => loc(),
                'country_code' => $user->country_code,
                'region_code' => $user->region_code,
                'price' => $media->price,
                'ends_at' => now()->addMonths(1),
                'payment_id' => $payment->id,
            ]);
        }
    }
}
