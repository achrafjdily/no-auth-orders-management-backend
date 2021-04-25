<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('App\Http\Controllers\Api')->group(function () {
    Route::resource('clients', ClientsController::class);
    Route::resource('orders', OrdersController::class)->except(['show']);
    Route::get('orders/confirm/{order}',[App\Http\Controllers\Api\OrdersController::class,'confirm']);
    Route::get('orders/delivered',[App\Http\Controllers\Api\OrdersController::class,'delivered']);
    // Controllers Within The 'App\Http\Controllers\Admin' Namespace
});
