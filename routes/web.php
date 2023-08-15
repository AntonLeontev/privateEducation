<?php

use App\Http\Controllers\AdminController;
use App\Models\Audio;
use App\Models\Fragment;
use App\Models\Subscription;
use App\Support\Enums\MediaLang;
use Carbon\Carbon;
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

Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('admin/custom', [AdminController::class, 'custom'])->name('admin.custom');
Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users');
