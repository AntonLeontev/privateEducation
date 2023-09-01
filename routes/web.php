<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\DB;
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

    $fragments = DB::table('views')
        ->select([
            'viewable_id',
            DB::raw('COUNT(viewable_id) AS count'),
        ])
        ->groupBy('viewable_id')
        ->orderByDesc('count')
        ->take(4)
        ->get();

    dd($fragments);

    return view('welcome');
});

Route::prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('custom', [AdminController::class, 'custom'])->name('custom');
        Route::get('users', [AdminController::class, 'users'])->name('users');

        Route::get('sales', [SubscriptionController::class, 'sales'])->name('sales');
        Route::get('sales/popular-fragments', [SubscriptionController::class, 'popularFragments'])->name('sales.popular-fragments');
        Route::get('metrics/sales', [SubscriptionController::class, 'metrics'])->name('metrics.sales');

        Route::get('views', [ViewController::class, 'views'])->name('views');
        Route::get('views/popular-fragments', [ViewController::class, 'popularFragments'])->name('views.popular-fragments');
        Route::get('metrics/views', [ViewController::class, 'metrics'])->name('metrics.views');
    });
