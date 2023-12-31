<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\app\Http\Controllers\ProductController;

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
    Route::get('/product', 'ProductController@index')->name('product.index');
    Route::get('/product/create', 'ProductController@create')->name('product.create');
    Route::post('/product', 'ProductController@store')->name('product.store');
    Route::get('/product/{slug}/edit', 'ProductController@edit')->name('product.edit');
    Route::put('/product/{slug}', 'ProductController@update')->name('product.update');
    Route::delete('/product/{id}', 'ProductController@destroy')->name('product.destroy');
});

Route::get('/chi-tiet-san-pham/{slug}', 'ClientProductController@detail')->name('client.product.detail');
