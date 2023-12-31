<?php

use Illuminate\Support\Facades\Route;
use Modules\SubCategory\app\Http\Controllers\SubCategoryController;

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
    Route::get('/sub-category', 'SubCategoryController@index')->name('subCategory.index');
    Route::get('/sub-category/create', 'SubCategoryController@create')->name('subCategory.create');
    Route::post('/sub-category', 'SubCategoryController@store')->name('subCategory.store');
    Route::get('/sub-category/{id}/edit', 'SubCategoryController@edit')->name('subCategory.edit');
    Route::put('/sub-category/{id}', 'SubCategoryController@update')->name('subCategory.update');
    Route::delete('/sub-category/{id}', 'SubCategoryController@destroy')->name('subCategory.destroy');
});
