<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BookingController;
use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group([
    'middleware' => ['api', 'throttle:60,1'],
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
});

Route::group([
    'prefix' => 'booking',
    'middleware' => ['auth:api', 'throttle:60,1'],
], function ($router) {
    Route::get('/history', [BookingController::class, 'history']);
    Route::post('/seat', [BookingController::class, 'seat'])->name('seat');
    Route::post('/transaction', [BookingController::class, 'transaction']);
});
Route::get('/schedules', [BookingController::class, 'index']);
Route::get('/cities', [BookingController::class, 'cities']);

Route::group([
    'prefix' => 'user',
    'middleware' => ['auth:api', 'throttle:60,1']
], function ($router) {
    Route::get('/profile', [UserController::class, 'profile'])->middleware('throttle:5,1');
    Route::get('/notifications', [UserController::class, 'notifications']);
});

Route::group([
    'prefix' => 'payment',
    'middleware' => ['auth:api', 'throttle:60,1']
], function ($router) {
    Route::get('/list', [PaymentController::class, 'list']);

    // Virtual Account
    Route::post('/create/va', [PaymentController::class, 'createVA']);

    // E-Wallet
    Route::post('/create/ewallet', [PaymentController::class, 'CreateEwallet']);
});

Route::group([
    'prefix' => 'callback',
    'middleware' => ['throttle:60,1']
], function ($router) {

    // Virtual Account
    Route::post('/va', [PaymentController::class, 'callbackVirtualAccountPaid']);

    // E-Wallet
    Route::post('/ewallet/status', [PaymentController::class, 'CallbackEwalletPaid']);
    Route::post('/ewallet/rekonsilisasi', [PaymentController::class, 'CallbackEwalletPaid']);
});
