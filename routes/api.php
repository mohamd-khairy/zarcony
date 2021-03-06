<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
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



Route::group([], function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
});


Route::group([], function () { //'middleware' => 'auth:sanctum'
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('users', [UserController::class, 'users']);
    Route::get('logs', [LogController::class, 'logs']);
    Route::put('user/edit/{id}', [UserController::class, 'edit_profile']);
    Route::delete('user/{id}', [UserController::class, 'delete']);
    Route::get('payments', [PaymentController::class, 'payments']);
    Route::post('payment/{user_id}', [PaymentController::class, 'add_payment']);
});
