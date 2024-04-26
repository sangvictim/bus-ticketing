<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BookingController;
use App\Http\Controllers\api\UserController;
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
});

Route::group([
    'prefix' => 'booking',
    'middleware' => 'auth:api'
], function ($router) {
    Route::get('/schedules', [BookingController::class, 'index']);
    Route::get('/history', [BookingController::class, 'history']);
    Route::get('/seat', [BookingController::class, 'seat'])->name('seat');
    Route::post('/transaction', [BookingController::class, 'transaction']);
});

Route::group([
    'prefix' => 'user',
    'middleware' => 'auth:api'
], function ($router) {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/notifications', [UserController::class, 'notifications']);
});
