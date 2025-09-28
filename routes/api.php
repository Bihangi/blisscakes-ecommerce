<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CakeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public cake and category routes (for browsing without auth)
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::get('/cakes', [CakeController::class, 'index']);
Route::get('/cakes/{cake}', [CakeController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // User profile routes
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', function(Request $request) {
        return app(UserController::class)->update($request, $request->user());
    });

    // Cart routes
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/items', [CartController::class, 'addItem']);
        Route::put('/items/{cartItem}', [CartController::class, 'updateItem']);
        Route::delete('/items/{cartItem}', [CartController::class, 'removeItem']);
        Route::delete('/clear', [CartController::class, 'clearCart']);
    });

    // Order routes
    Route::apiResource('orders', OrderController::class);

    // Admin only routes
    Route::middleware('admin')->group(function () {
        // Category management
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
        
        // Cake management
        Route::apiResource('cakes', CakeController::class)->except(['index', 'show']);
        
        // User management
        Route::apiResource('users', UserController::class);
        
        // Admin order management (all orders)
        Route::get('/admin/orders', [OrderController::class, 'index']);
        Route::put('/admin/orders/{order}/status', function(Request $request, Order $order) {
            return app(OrderController::class)->update($request, $order);
        });
    });
});