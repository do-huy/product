<?php

use Illuminate\Support\Facades\Route;
use Modules\User\app\Http\Controllers\UserController;

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

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', ])->group(function () {
    Route::get('/user', 'UserController@index')->name('user.index');
    Route::get('/user/create', 'UserController@create')->name('user.create');
    Route::post('/user', 'UserController@store')->name('user.store');
    Route::get('/user/{user}/edit', 'UserController@edit')->name('user.edit');
    Route::put('/user/{user}', 'UserController@update')->name('user.update');
    Route::delete('/user/{user}', 'UserController@destroy')->name('user.destroy');
    Route::get('/user/{id}/edit-password', 'UserController@edit_password')->name('user.edit.pasword');
    Route::put('/user/{id}/update-password', 'UserController@update_password')->name('user.update.pasword');
});

//client
Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/thong-tin-tai-khoan', 'ClientProfileController@profile')->name('client.profile.index');
    Route::post('/thong-tin-tai-khoan', 'ClientProfileController@update_profile')->name('client.profile.update');

    Route::get('/cap-nhap-so-dien-thoai', 'ClientProfileController@phone')->name('client.profile.phone');
    Route::post('/cap-nhap-so-dien-thoai', 'ClientProfileController@update_phone')->name('client.profile.phone.update');

    Route::get('/cap-nhap-email', 'ClientProfileController@email')->name('client.profile.email');
    Route::post('/cap-nhap-email', 'ClientProfileController@update_email')->name('client.profile.email.update');

    Route::get('/thay-doi-mat-khau', 'ClientProfileController@password')->name('client.profile.password');
    Route::put('/thay-doi-mat-khau', 'ClientProfileController@update_password')->name('client.profile.password.update');

});


