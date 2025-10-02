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
use App\Livewire\UserManagement;
use App\Http\Controllers\Auth\AdminLoginController;

/* PUBLIC ROUTES */
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('frontend.about');
})->name('about');

/* ADMIN LOGIN ROUTES */
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout')->middleware('auth');

/* CUSTOMER ROUTES */
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    // Check if user is admin and redirect
    Route::get('/home', function () {
        if (auth()->user()->user_type === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('frontend.home');
    })->name('home');

    Route::get('/cakes', CakeBrowser::class)->name('cakes.browse');
    Route::get('/cart', CartManagement::class)->name('cart');
    Route::get('/checkout', function () {
        return view('frontend.checkout');
    })->name('checkout');
    Route::get('/dashboard', UserDashboard::class)->name('dashboard');
    Route::get('/my-orders', function () {
        return view('customer.orders');
    })->name('customer.orders');
});

/* ADMIN ROUTES */
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'admin.web'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
        Route::get('/cakes', CakeManagement::class)->name('cakes');
        Route::get('/categories', CategoryManagement::class)->name('categories');
        Route::get('/orders', OrderManagement::class)->name('orders');
        Route::get('/reviews', function () {
            return view('reviews.index'); 
        })->name('reviews');
        Route::get('/users', UserManagement::class)->name('users');
        Route::get('/customers', UserManagement::class)->name('customers');
        Route::get('/notifications', NotificationSystem::class)->name('notifications');
    });