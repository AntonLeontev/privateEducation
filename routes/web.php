<?php

use App\Http\Controllers\AdminController;
use App\Models\Subscription;
use App\Support\Enums\MediaLang;
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

Route::get('/', function () {

    $fragment = Subscription::query()
        ->selectRaw('COUNT(price) as count, location')
        ->where('lang', MediaLang::ru)
        ->where('created_at', '>=', now()->subYear())
        ->groupBy('location')
        ->pluck('count', 'location')
        ->toArray();

    dd($fragment);

    return view('welcome');
});

Route::prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('custom', [AdminController::class, 'custom'])->name('custom');
        Route::get('users', [AdminController::class, 'users'])->name('users');
        Route::get('metrics/sales', [AdminController::class, 'salesMetrics'])->name('metrics.sales');
        Route::get('sales', [AdminController::class, 'sales'])->name('sales');
        Route::get('popular-fragments', [AdminController::class, 'popularFragments'])->name('popular-fragments');
    });
