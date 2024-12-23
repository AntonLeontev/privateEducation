<?php

namespace App\Http\Controllers;

use App\Enums\Currency;
use App\Enums\PaymentStatus;
use App\Http\Requests\PaymentsIndexRequest;
use App\Models\Audio;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Video;
use App\Services\Stripe\StripeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function page()
    {
        return view('admin.payments');
    }

    public function index(PaymentsIndexRequest $request)
    {
        [$start, $end] = $request->getPeriodDates();

        $actions = Payment::query()
            ->where('created_at', '>=', $start->startOfDay())
            ->where('created_at', '<=', $end->endOfDay())
            ->orderByDesc('created_at')
            ->with('user')
            ->simplePaginate(25);

        return response()->json($actions);
    }

    public function checkout(Request $request, StripeService $stripe): JsonResponse
    {
        app()->setLocale($request->get('locale'));

        if ($request->get('media_type') === 'video') {
            $media = Video::where('fragment_id', $request->get('fragment_id'))->first();
        }
        if ($request->get('media_type') === 'audio') {
            $media = Audio::where('fragment_id', $request->get('fragment_id'))->first();
        }

        if (! empty($media->subscription)) {
            throw ValidationException::withMessages(['subscription' => 'Already subscribed']);
        }

        if (loc() === 'ru') {
            $price = $media->price;
        } elseif (loc() === 'en') {
            $price = $media->price->toUsd();
        }

        $payment = Payment::create([
            'user_id' => auth()->id(),
            'amount' => $price,
            'currency' => $price->currency,
            'fragment_id' => $request->get('fragment_id'),
            'media_type' => $request->get('media_type'),
            'status' => PaymentStatus::init,
        ]);

        $stripeSession = $stripe->createSession($price, $request->get('fragment_id'), $request->get('media_type'), $payment->id);

        $payment->external_id = $stripeSession->id;
        $payment->save();

        return response()->json(['redirect' => $stripeSession->url]);
    }

    public function success(Payment $payment, StripeService $stripe): RedirectResponse
    {
        if (! $stripe->checkSessionSuccess($payment->external_id)) {
            return to_route('home', ['step' => 'fail', 'fragment_id' => $payment->fragment_id, 'media_type' => $payment->media_type]);
        }

        $payment->confirmed_by_redirect_at = now();
        $payment->status = PaymentStatus::success;
        $payment->save();

        $builder = $payment->media_type === 'video' ? Video::query() : Audio::query();

        $media = $builder->where('fragment_id', $payment->fragment_id)
            ->with('subscription')
            ->first();

        if (empty($media->subscription)) {
            $locale = $payment->currency === Currency::usd ? 'en' : 'ru';
            $user = User::find($payment->user_id);

            Subscription::create([
                'user_id' => $payment->user_id,
                'subscribable_id' => $media->id,
                'subscribable_type' => $media->subscribableType(),
                'lang' => $locale,
                'country_code' => $user->country_code,
                'region_code' => $user->region_code,
                'price' => $media->price,
                'ends_at' => now()->addMonths(1),
                'payment_id' => $payment->id,
            ]);
        }

        return to_route('home', ['step' => 'success', 'fragment_id' => $payment->fragment_id, 'media_type' => $payment->media_type]);
    }

    public function fail(Payment $payment): RedirectResponse
    {
        if ($payment->status !== PaymentStatus::init) {
            abort(404);
        }

        if ($payment->created_at->diffInHours(now()) > 24) {
            abort(404);
        }

        $payment->status = PaymentStatus::declined;
        $payment->save();

        return to_route('home', ['step' => 'fail', 'fragment_id' => $payment->fragment_id, 'media_type' => $payment->media_type]);
    }
}
