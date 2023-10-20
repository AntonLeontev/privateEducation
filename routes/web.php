<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PresentationViewController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/test', function () {
        return route('verify-email', ['123', bcrypt('654')]);
    });
}

Route::get('/', HomeController::class)->name('home');
Route::view('about', 'about')->name('about');
Route::view('copyright', 'copyright')->name('copyright');
Route::view('commercial', 'commercial')->name('commercial');
Route::view('privacy', 'privacy')->name('privacy');
Route::view('contacts', 'contacts')->name('contacts');
Route::get('/verify-email/{user:email}', [UserController::class, 'verifyEmail'])->name('verify-email');
Route::middleware('guest')
    ->post('register', [RegisterUserController::class, 'store'])
    ->name('register');

Route::prefix('my')
    ->middleware('auth')
    ->group(function () {
        Route::view('account', 'my.account')->name('my.account');
        Route::view('media', 'my.media')->name('my.media');
        Route::view('password', 'my.password')->name('my.password');
    });

Route::prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('custom', [AdminController::class, 'custom'])->name('custom');
        Route::get('users', [AdminController::class, 'users'])->name('users');
        Route::get('users/subscriptions', [UserController::class, 'subscriptions'])->name('users.subscriptions');
        Route::post('users/subscriptions/search', [UserController::class, 'subscriptionsSearch'])->name('users.subscriptions.search');
        Route::get('files', [AdminController::class, 'files'])->name('files');
        Route::get('prices', [AdminController::class, 'prices'])->name('prices');

        Route::get('sales', [SubscriptionController::class, 'sales'])->name('sales');
        Route::get('sales/popular-fragments', [SubscriptionController::class, 'popularFragments'])->name('sales.popular-fragments');
        Route::get('metrics/sales', [SubscriptionController::class, 'metrics'])->name('metrics.sales');

        Route::get('views', [ViewController::class, 'views'])->name('views');
        Route::get('views/popular-fragments', [ViewController::class, 'popularFragments'])->name('views.popular-fragments');
        Route::get('metrics/views', [ViewController::class, 'metrics'])->name('metrics.views');

        Route::get('presentation-views', [PresentationViewController::class, 'index'])->name('pres');
        Route::get('pres/popular-fragments', [PresentationViewController::class, 'popularFragments'])->name('pres.popular-fragments');
        Route::get('metrics/pres', [PresentationViewController::class, 'metrics'])->name('metrics.pres');

        Route::post('fragments/{id}/audio/price', [AudioController::class, 'price'])->name('audio.update.price');

        Route::post('fragments/{id}/video/price', [VideoController::class, 'price'])->name('video.update.price');
    });
