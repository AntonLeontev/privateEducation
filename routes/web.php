<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Stripe\Checkout\Session;
use Stripe\Stripe;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

if (app()->isLocal()) {
    Route::get('/test', function (Stripe $stripe) {
        $stripe->setApiKey(config('services.stripe.secret_key'));

        $domain = 'http://127.0.0.1:8000';
        $session = Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => 623,
                        'product_data' => [
                            'name' => 'Fragment 1. Video',
                        ],
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            // 'client_reference_id' => auth()->id() ?? 123,
            // 'customer' => 'string',
            'locale' => 'ru',
            'success_url' => $domain.'/stripe/success',
            'return_url' => $domain.'/stripe/return',
            'cancel_url' => $domain,
        ]);
        dd($session);
    });
}

Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect'])
    ->group(static function () {
        Route::get('/', HomeController::class)->name('home');
        Route::view('about', 'about')->name('about');
        Route::view('copyright', 'copyright')->name('copyright');
        Route::view('commercial', 'commercial')->name('commercial');
        Route::view('privacy', 'privacy')->name('privacy');
        Route::view('contacts', 'contacts')->name('contacts');

        Route::middleware(['guest'])->group(function () {
            Route::get('/login', [AuthController::class, 'create'])->name('login');
            Route::post('/login', [AuthController::class, 'login'])->name('auth');
            Route::get('/verify-email/{user:email}', [AuthController::class, 'verifyEmail'])->name('verify-email');
            Route::post('register', [AuthController::class, 'store'])->name('register');
            Route::post('register-and-buy', [AuthController::class, 'storeAndBuy'])->name('register-and-buy');
            Route::post('/password-reset', [AuthController::class, 'resetPassword'])->name('password.reset');
        });
        Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

        Route::middleware(['auth'])->group(function () {
            Route::get('account', [UserController::class, 'personal'])
                ->name('personal');
            Route::post('account', [UserController::class, 'update'])
                ->name('personal.update');
            Route::post('personal/password', [UserController::class, 'updatePassword'])
                ->name('account.password');
        });
    });

Route::post('feedback', FeedbackController::class)->name('feedback');

Route::get('media/{type}/{fragmentId}/{lang}/{sound}/{device}', [MediaController::class, 'show'])
    ->whereIn('type', ['audio', 'presentation', 'video'])
    ->whereIn('fragmentId', range(1, 17))
    ->whereIn('lang', ['en', 'ru'])
    ->whereIn('sound', ['mono', 'stereo'])
    ->whereIn('device', ['mobile', 'tablet', 'notebook'])
    ->name('media.show');

Route::post('checkout', [PaymentController::class, 'checkout'])->name('payment.create');
Route::get('payment/{payment:external_id}/success', [PaymentController::class, 'success'])->name('payment.success');

include 'admin.php';
