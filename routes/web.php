<?php

use App\Http\Controllers\ActionLogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\FragmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\PresentationViewController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ViewController;
use App\Services\CurrencyRatesService\CurrencyRatesService;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
    Route::get('/test', function (CurrencyRatesService $service) {
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

        Route::get('/verify-email/{user:email}', [UserController::class, 'verifyEmail'])->name('verify-email');
        Route::post('/password-reset', PasswordResetController::class)->name('password.reset');

        Route::view('/login', 'auth.login')->name('login');

        Route::middleware('guest')
            ->post('register', [RegisterUserController::class, 'store'])
            ->name('register');

        Route::middleware(['auth'])
            ->get('account', [UserController::class, 'personal'])
            ->name('personal');
    });

Route::get('media/{type}/{fragmentId}/{lang}/{sound}/{device}', [MediaController::class, 'show'])
    ->whereIn('type', ['audio', 'presentation', 'video'])
    ->whereIn('fragmentId', range(1, 17))
    ->whereIn('lang', ['en', 'ru'])
    ->whereIn('sound', ['mono', 'stereo'])
    ->whereIn('device', ['mobile', 'tablet', 'notebook'])
    ->name('media.show');

Route::prefix('admin')
    ->as('admin.')
    ->group(function () {

        Route::middleware('admin.guest')
            ->group(function () {
                Route::get('login', [AdminLoginController::class, 'create'])->name('login.create');
                Route::post('login', [AdminLoginController::class, 'store'])
                    ->middleware('throttle:5,5')
                    ->name('login.store');
                Route::post('two-factor-check-code', [AdminLoginController::class, 'twoFactorCheckCode'])
                    ->middleware('throttle:5,5')
                    ->name('two-factor.check');
            });

        Route::middleware('admin')
            ->group(function () {
                Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

                Route::middleware(['only_admin'])
                    ->group(function () {
                        Route::get('/', [AdminController::class, 'fragments'])->name('fragments');
                        Route::get('users', [AdminController::class, 'users'])->name('users');
                        Route::get('files', [AdminController::class, 'files'])->name('files');
                        Route::get('prices', [AdminController::class, 'prices'])->name('prices');
                        Route::get('deactivation', [AdminController::class, 'deactivation'])->name('deactivation');

                        Route::get('admins', [AdminController::class, 'admins'])->name('admins');
                        Route::post('admins/create', [AdminController::class, 'adminStore'])->name('admins.store');
                        Route::delete('admins/{admin}/delete', [AdminController::class, 'adminDestroy'])->name('admins.destroy');

                        Route::get('users/subscriptions', [UserController::class, 'subscriptions'])->name('users.subscriptions');
                        Route::post('users/subscriptions/search', [UserController::class, 'subscriptionsSearch'])->name('users.subscriptions.search');

                        Route::get('sales', [SubscriptionController::class, 'sales'])->name('sales');
                        Route::get('sales/popular-fragments', [SubscriptionController::class, 'popularFragments'])->name('sales.popular-fragments');
                        Route::get('metrics/sales', [SubscriptionController::class, 'metrics'])->name('metrics.sales');

                        Route::get('views', [ViewController::class, 'views'])->name('views');
                        Route::get('views/popular-fragments', [ViewController::class, 'popularFragments'])->name('views.popular-fragments');
                        Route::get('metrics/views', [ViewController::class, 'metrics'])->name('metrics.views');

                        Route::get('presentation-views', [PresentationViewController::class, 'index'])->name('pres');
                        Route::get('pres/popular-fragments', [PresentationViewController::class, 'popularFragments'])->name('pres.popular-fragments');
                        Route::get('metrics/pres', [PresentationViewController::class, 'metrics'])->name('metrics.pres');

                        Route::post('fragments/{fragment}/update', [FragmentController::class, 'update'])->name('fragments.update');

                        Route::post('audio/{audio}/update', [AudioController::class, 'update'])->name('audio.update');

                        Route::post('videos/{video}/update', [VideoController::class, 'update'])->name('video.update');

                        Route::post('presentations/{presentation}/update', [PresentationController::class, 'update'])
                            ->name('presentations.update');

                        Route::post('media/create', [MediaController::class, 'store'])->name('media.store');

                        Route::get('actions', [ActionLogController::class, 'page'])->name('actions.page');
                        Route::get('actions/index', [ActionLogController::class, 'index'])->name('actions.index');

                        Route::get('payments', [PaymentController::class, 'page'])->name('payments.page');
                        Route::get('payments/index', [PaymentController::class, 'index'])->name('payments.index');
                    });

                Route::middleware(['admin.detect'])
                    ->group(function () {
                        Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
                    });
            });
    });
