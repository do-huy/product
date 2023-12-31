<?php

use Illuminate\Support\Facades\Route;
use Modules\CheckOut\app\Http\Controllers\CheckOutController;

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
    Route::get('/dia-chi-ca-nhan', 'CheckOutController@choseAddress')->name('checkout.address');
    Route::post('/dia-chi-ca-nhan', 'CheckOutController@choseAddressStore')->name('client.choseAddress.store');

    Route::post('/hoa-don', 'CheckOutController@chosePayment')->name('checkout.payment');
    Route::post('/checkout', 'CheckOutController@store')->name('checkout.store');
    Route::get('/dat-hang-thanh-cong', 'CheckOutController@billShow')->name('bill.show');

});
