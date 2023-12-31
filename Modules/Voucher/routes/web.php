<?php

use Illuminate\Support\Facades\Route;
use Modules\Voucher\app\Http\Controllers\VoucherController;

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

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/danh-sach-ma-khuyen-mai', 'VoucherController@index')->name('client.vouchers.index');
    Route::get('/ma-khuyen-mai/{code}', 'VoucherController@detail')->name('client.vouchers.detail');
});
