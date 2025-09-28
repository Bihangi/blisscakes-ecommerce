<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Cake;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart()->with(['cartItems.cake'])->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }

        return new CartResource($cart);
    }

    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'cake_id' => 'required|exists:cakes,id',
            'quantity' => 'required|integer|min:1',
            'customization' => 'nullable|array',
        ]);

        $user = $request->user();
        $cake = Cake::findOrFail($validated['cake_id']);

        if (!$cake->is_available) {
            return response()->json(['message' => 'Cake is not available'], 400);
        }

        // Get or create cart
        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);

        // Check if item already exists in cart
        $existingItem = $cart->cartItems()->where('cake_id', $cake->id)->first();

        if ($existingItem) {
            // Update quantity
            $existingItem->update([
                'quantity' => $existingItem->quantity + $validated['quantity'],
                'customization' => $validated['customization'] ?? $existingItem->customization,
            ]);
            $cartItem = $existingItem;
        } else {
            // Create new cart item
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'cake_id' => $cake->id,
                'quantity' => $validated['quantity'],
                'price' => $cake->price,
                'customization' => $validated['customization'],
            ]);
        }

        return new CartItemResource($cartItem->load('cake'));
    }

    public function updateItem(Request $request, CartItem $cartItem)
    {
        // Ensure user owns this cart item
        if ($cartItem->cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'customization' => 'nullable|array',
        ]);

        $cartItem->update($validated);
        return new CartItemResource($cartItem->load('cake'));
    }

    public function removeItem(CartItem $cartItem)
    {
        // Ensure user owns this cart item
        if ($cartItem->cart->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();
        return response()->json(['message' => 'Item removed from cart']);
    }

    public function clearCart(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart;

        if ($cart) {
            $cart->cartItems()->delete();
        }

        return response()->json(['message' => 'Cart cleared successfully']);
    }
}