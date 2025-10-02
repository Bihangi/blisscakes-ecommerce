<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        // Get cart with cart items
        $cart = $user->cart()->with('cartItems.cake')->first();

        if (!$cart || $cart->isEmpty()) {
            return response()->json([
                'message' => 'Your cart is empty.'
            ], 400);
        }

        $validated = $request->validate([
            'delivery_address' => 'required|string|max:255',
            'delivery_phone' => 'required|string|max:20',
            'special_instructions' => 'nullable|string|max:500',
        ]);

        // Create order
        $order = $user->orders()->create([
            'delivery_address' => $validated['delivery_address'],
            'delivery_phone' => $validated['delivery_phone'],
            'special_instructions' => $validated['special_instructions'] ?? null,
            'total_amount' => $cart->total_amount,
        ]);

        // Attach cart items to order
        foreach ($cart->cartItems as $item) {
            $order->orderItems()->create([
                'cake_id' => $item->cake_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'customization' => $item->customization,
            ]);
        }

        // Clear cart
        $cart->cartItems()->delete();

        return response()->json([
            'message' => 'Order created successfully',
            'order_id' => $order->id
        ]);
    }

    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.cake']); // use orderItems

        if ($request->user()->user_type === 'customer') {
            $query->where('user_id', $request->user()->id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(15);

        return response()->json($orders);
    }

    public function show($id, Request $request)
    {
        $query = Order::with(['user', 'orderItems.cake']);

        if ($request->user()->user_type === 'customer') {
            $query->where('user_id', $request->user()->id);
        }

        $order = $query->findOrFail($id);

        return response()->json($order);
    }

    public function updateStatus(Request $request, $id)
    {
        if ($request->user()->user_type !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated',
            'data' => $order
        ]);
    }
}
