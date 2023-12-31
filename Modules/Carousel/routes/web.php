<?php

use Illuminate\Support\Facades\Route;
use Modules\Carousel\app\Http\Controllers\CarouselController;

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
    Route::get('/carousel', 'CarouselController@index')->name('carousel.index');
    Route::get('/carousel/create', 'CarouselController@create')->name('carousel.create');
    Route::post('/carousel', 'CarouselController@store')->name('carousel.store');
    Route::get('/carousel/{id}/edit', 'CarouselController@edit')->name('carousel.edit');
    Route::put('/carousel/{id}', 'CarouselController@update')->name('carousel.update');
    Route::delete('/carousel/{id}', 'CarouselController@destroy')->name('carousel.destroy');
});
