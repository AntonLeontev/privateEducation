<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PresentationViewController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewController;
use App\Models\Payment;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
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
        app()->setLocale('en');
        $payment = Payment::find(28);

        dump($payment->amount);
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
            Route::post('/login', [AuthController::class, 'login'])->name('auth')
                ->middleware(['throttle:10,1']);
            Route::get('/verify-email/{user:email}', [AuthController::class, 'verifyEmail'])->name('verify-email');
            Route::post('register', [AuthController::class, 'store'])->name('register');
            Route::post('register-and-buy', [AuthController::class, 'storeAndBuy'])->name('register-and-buy');
            Route::post('/password-reset', [AuthController::class, 'resetPassword'])->name('password.reset')
                ->middleware(['throttle:5,1']);
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
Route::get('media/text/{fragmentId}/{lang}', [MediaController::class, 'text'])
    ->whereIn('fragmentId', range(1, 17))
    ->whereIn('lang', ['en', 'ru'])
    ->name('media.text');

Route::middleware(['auth'])->group(function () {
    Route::post('checkout', [PaymentController::class, 'checkout'])->name('payment.create');
    Route::get('payment/{payment}/success', [PaymentController::class, 'success'])->name('payment.success');

    Route::post('view', [ViewController::class, 'store'])->name('view.store');
    Route::post('presentation-view', [PresentationViewController::class, 'store'])->name('presentation-view.store');
});

Route::post('webhooks/stripe', [StripeController::class, 'webhook'])->name('webhooks.stripe');
Route::post('error-watch', function () {})->name('error.watch');

include 'admin.php';
