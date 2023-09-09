<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PresentationViewController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ViewController;
use App\Models\Subscription;
use App\Models\User;
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

	$fragments = collect();

    $subs = Subscription::query()
		->where('user_id', 25)
		->orderByDesc('created_at')
		->get();

	
	foreach ($subs as $sub) {
		$key = $sub->subscribable_id . '.' . str($sub->subscribable_type)->afterLast('\\')->lower();

		if ($fragments->has($key)) {
			continue;
		}

		$fragments->put($key, [
			'created_at' => $sub->created_at,
			'ends_at' => $sub->ends_at,
		]);
	}

	$fragments = $fragments->undot();


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

        Route::get('presentation-views', [PresentationViewController::class, 'index'])->name('pres');
        Route::get('pres/popular-fragments', [PresentationViewController::class, 'popularFragments'])->name('pres.popular-fragments');
        Route::get('metrics/pres', [PresentationViewController::class, 'metrics'])->name('metrics.pres');
    });
