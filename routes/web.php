<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Kitchen\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Delivery\DashboardController as DeliveryDashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    //orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');
    });

    Route::prefix('kitchen')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('kitchen.dashboard');
    });

    Route::prefix('delivery')->group(function () {
        Route::get('/dashboard', [DeliveryDashboardController::class, 'index'])
            ->name('delivery.dashboard');
    });
});
require __DIR__.'/auth.php';
