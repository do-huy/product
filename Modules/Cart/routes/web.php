<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\app\Http\Controllers\CartController;

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
    Route::get('/gio-hang', 'CartController@detailCart')->name('client.cart.detail');
    Route::post('/add-to-cart', 'CartController@storeCart')->name('client.cart.store');
    Route::post('/cart-select/{id}', 'CartController@selectCartItem')->name('cart.select');
    Route::post('/cart-up/{id}', 'CartController@updateUp')->name('cart.up');
    Route::post('/cart-down/{id}', 'CartController@updateDown')->name('cart.down');
    Route::post('/cart/add-voucher/{id}', 'CartController@selectVoucherForCart')->name('cart.voucher');
    Route::post('/cart/add-voucher-all', 'CartController@selectVoucherForAll')->name('cart.voucher.all');
    Route::post('/cart/remove-voucher', 'CartController@removeVoucher')->name('cart.voucher.remove');
    Route::delete('/xoa-gio-hang/{id}', 'CartController@destroy')->name('destroy.cart');
});
