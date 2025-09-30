<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CakeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;

// Public API routes
Route::get('/cakes', [CakeController::class, 'index']);
Route::get('/cakes/{id}', [CakeController::class, 'show']);
Route::get('/cakes/{cakeId}/reviews', [ReviewController::class, 'index']);

// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Cake routes (Admin only for create/update/delete)
    Route::middleware('admin')->group(function () {
        Route::post('/cakes', [CakeController::class, 'store']);
        Route::put('/cakes/{id}', [CakeController::class, 'update']);
        Route::delete('/cakes/{id}', [CakeController::class, 'destroy']);
        Route::post('/cakes/{id}/toggle-availability', [CakeController::class, 'toggleAvailability']);

        // Admin: Get all reviews
        Route::get('/admin/reviews', [ReviewController::class, 'getAllReviews']);
    });

    // Order routes
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);
    
    // Admin only order routes
    Route::middleware('admin')->group(function () {
        Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
    });

    // Review routes (stored in JSON/NoSQL style field)
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

    // Cart routes
    Route::prefix('cart')->group(function () {
        Route::post('/items', function (Request $request) {
            $cake = \App\Models\Cake::findOrFail($request->cake_id);
            $cart = auth()->user()->cart ?? auth()->user()->cart()->create();
            
            $cart->cartItems()->create([
                'cake_id' => $request->cake_id,
                'quantity' => $request->quantity,
                'price' => $cake->price,
                'customization' => $request->customization,
            ]);
            
            return response()->json(['success' => true]);
        });
    });
});
