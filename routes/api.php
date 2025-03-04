<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\{CustomerAuthController, PaymentController};
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('customers')->group(function () {
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::post('/login', [CustomerAuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('/payment', [PaymentController::class, 'processPayment']);
});
