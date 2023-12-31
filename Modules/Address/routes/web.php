<?php

use Illuminate\Support\Facades\Route;
use Modules\Address\app\Http\Controllers\AddressController;

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

//client
Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/dia-chi', 'ClientAddressController@address')->name('client.profile.address');
    Route::get('/them-moi-dia-chi', 'ClientAddressController@create_address')->name('client.profile.create.address');
    Route::post('/them-moi-dia-chi', 'ClientAddressController@store_address')->name('client.profile.store.address');

    Route::get('/them-moi-dia-chi/{slug}', 'ClientAddressController@edit_address')->name('client.profile.edit.address');
    Route::put('/them-moi-dia-chi/{slug}', 'ClientAddressController@update_address')->name('client.profile.update.address');


    Route::delete('/xoa-dia-chi/{id}', 'ClientAddressController@destroy_address')->name('client.profile.destroy.address');
});
