<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CakeBrowser;
use App\Livewire\CartManagement;
use App\Livewire\CakeManagement;
use App\Livewire\Checkout;
use App\Livewire\OrderManagement;
use App\Livewire\UserDashboard;
use App\Livewire\AdminDashboard;
use App\Livewire\CakeReviews;
use App\Livewire\CategoryManagement;
use App\Livewire\NotificationSystem;
use App\Http\Controllers\Auth\TwoFactorAuthController;
use App\Livewire\UserManagement;
use App\Http\Controllers\Auth\ForgotPasswordController;
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

Route::get('/cakes', CakeBrowser::class)->name('cakes.browse');

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


    Route::get('/cakes/{cakeId}/reviews', CakeReviews::class)->name('cakes.reviews');
    Route::get('/cart', CartManagement::class)->name('cart');
    Route::get('/checkout', function () {
        return view('frontend.checkout');
    })->name('checkout');
    Route::get('/orders', UserDashboard::class)->name('orders');
    Route::get('/my-orders', function () {
        return view('customer.orders');
    })->name('customer.orders');
    Route::get('/checkout', Checkout::class)->name('checkout')->middleware('auth');
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

// Forgot Password Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.send-otp');
Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyOtpForm'])->name('password.verify-otp');
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify-otp.submit');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset-form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
Route::post('/resend-otp', [ForgotPasswordController::class, 'resendOtp'])->name('password.resend-otp');

// 2FA Routes
Route::get('/two-factor-challenge', [TwoFactorAuthController::class, 'show'])->name('two-factor.login');
Route::post('/two-factor-challenge', [TwoFactorAuthController::class, 'verify'])->name('two-factor.verify');
Route::post('/two-factor/resend', [TwoFactorAuthController::class, 'resend'])->name('two-factor.resend');

// 2FA Settings (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/user/two-factor-settings', function () {
        return view('profile.two-factor-settings');
    })->name('two-factor.settings');
    Route::post('/user/two-factor/enable', [TwoFactorAuthController::class, 'enable'])->name('two-factor.enable');
    Route::post('/user/two-factor/disable', [TwoFactorAuthController::class, 'disable'])->name('two-factor.disable');
});