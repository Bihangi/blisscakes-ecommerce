<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CakeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\CustomerAuthController;

/* PUBLIC API ROUTES */

// Authentication
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/customer/register', [CustomerAuthController::class, 'register']);
Route::post('/customer/login', [CustomerAuthController::class, 'login']);

// Public Cake Browsing
Route::get('/cakes', [CakeController::class, 'index']);
Route::get('/cakes/{id}', [CakeController::class, 'show']);

// Public Reviews
Route::get('/cakes/{cakeId}/reviews', [ReviewController::class, 'index']);

/* PROTECTED API ROUTES (Customer) */

Route::middleware('auth:sanctum')->group(function () {
    
    // Get Current User
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Customer Logout
    Route::post('/customer/logout', [CustomerAuthController::class, 'logout']);

    // Cart Management
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/items', [CartController::class, 'addItem']);
        Route::put('/items/{id}', [CartController::class, 'updateItem']);
        Route::delete('/items/{id}', [CartController::class, 'removeItem']);
        Route::delete('/', [CartController::class, 'clear']);
    });

    // Order Management (Customer)
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);

    // Reviews (Customer can create/delete their own)
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
});

/* PROTECTED API ROUTES (Admin Only) */

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    
    // Admin Logout
    Route::post('/logout', [AdminAuthController::class, 'logout']);

    // Cake Management
    Route::post('/cakes', [CakeController::class, 'store']);
    Route::put('/cakes/{id}', [CakeController::class, 'update']);
    Route::delete('/cakes/{id}', [CakeController::class, 'destroy']);
    Route::post('/cakes/{id}/toggle-availability', [CakeController::class, 'toggleAvailability']);

    // Order Management (Admin can update order status)
    Route::get('/orders', [OrderController::class, 'getAllOrders']);
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);

    // Review Management (Admin can view/delete all reviews)
    Route::get('/reviews', [ReviewController::class, 'getAllReviews']);
    Route::delete('/reviews/{id}/admin', [ReviewController::class, 'adminDestroy']);

    // Customer Management
    Route::get('/customers', function () {
        return \App\Models\User::where('role', 'customer')->get();
    });
});