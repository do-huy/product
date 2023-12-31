<?php

use Illuminate\Support\Facades\Route;
use Modules\Bill\app\Http\Controllers\BillController;

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
    Route::get('/chi-tiet-don-hang', 'ClientBillController@index')->name('client.bill.index');
    Route::get('/chi-tiet/{id}', 'ClientBillController@detail')->name('client.bill.detail');
});
