<?php

namespace App\Services\Stripe;

use App\Support\ValueObjects\Price;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeService
{
    public function __construct(public Stripe $stripe)
    {
        $this->stripe->setApiKey(config('services.stripe.secret_key'));
    }

    public function createSession(Price $price, int $fragmentId, string $mediaType, int $paymentId): Session
    {
        $mediaName = $mediaType === 'video' ? __('ui.resource.stripe.video') : __('ui.resource.stripe.audio');

        $session = Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => mb_strtolower($price->currency->getCode()),
                        'unit_amount' => (int) round($price->amount),
                        'product_data' => [
                            'name' => __('ui.resource.stripe.fragment').$fragmentId.'. '.$mediaName,
                        ],
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'client_reference_id' => auth()->id(),
            // 'customer' => 'string',
            'locale' => 'ru',
            'success_url' => route('payment.success', $paymentId),
            'cancel_url' => route('home', ['fragment_id' => $fragmentId, 'media_type' => $mediaType, 'step' => 'step5']),
        ]);

        return $session;
    }

    public function checkSessionSuccess(string $sessionId): bool
    {
        $session = Session::retrieve($sessionId);

        return $session->payment_status === 'paid';
    }
}
