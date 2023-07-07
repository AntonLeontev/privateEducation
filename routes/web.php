<?php

use App\Models\Audio;
use App\Models\Fragment;
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

	// $fragment = Fragment::with(['audio', 'video', 'presentation'])->first()->video->media->first()->sound;

	// dd($fragment);

    return view('welcome');
});
