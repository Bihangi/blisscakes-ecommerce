<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CakeBrowser;
use App\Livewire\CartManagement;
use App\Livewire\CakeManagement;
use App\Livewire\OrderManagement;
use App\Livewire\UserDashboard;
use App\Livewire\AdminDashboard;
use App\Livewire\CategoryManagement;
use App\Livewire\NotificationSystem;

// Public routes
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/cakes', CakeBrowser::class)->name('cakes.browse');

// Customer routes (authenticated)
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', UserDashboard::class)->name('dashboard');

    Route::get('/cart', CartManagement::class)->name('cart');

    Route::get('/my-orders', function () {
        return view('customer.orders');
    })->name('customer.orders');
});

// Admin routes
Route::middleware(['auth:sanctum', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');

        Route::get('/cakes', CakeManagement::class)->name('cakes');
        Route::get('/orders', OrderManagement::class)->name('orders');
        Route::get('/categories', CategoryManagement::class)->name('categories');
        Route::get('/notifications', NotificationSystem::class)->name('notifications');
    });

    // Admin Login
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])
        ->name('admin.login');

    Route::post('/admin/login', [AdminLoginController::class, 'login'])
        ->name('admin.login.submit');

        

