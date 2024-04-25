<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

Route::group([
    'prefix' => 'booking',
    'middleware' => 'auth:api'
], function ($router) {
    Route::get('/schedules', [BookingController::class, 'index']);
    Route::get('/history', [BookingController::class, 'history']);
    // Route::get('/seat', [BookingController::class, 'index'])->name('seat');
    // Route::get('/payment', [BookingController::class, 'index'])->name('payment');
});
