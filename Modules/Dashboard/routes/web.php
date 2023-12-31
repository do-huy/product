<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\app\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware([ 'auth:sanctum', config('jetstream.auth_session'), 'verified', ])->group(function () {
    Route::group([], function () {
        Route::resource('dashboard', DashboardController::class)->names('dashboard');
    });
});
