<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.cake']);

        // Filter by user (for customers to see only their orders)
        if ($request->user() && $request->user()->isCustomer()) {
            $query->where('user_id', $request->user()->id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->has('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 10));
        return OrderResource::collection($orders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'delivery_address' => 'required|string',
            'delivery_phone' => 'required|string',
            'delivery_date' => 'nullable|date|after:now',
            'special_instructions' => 'nullable|string',
        ]);

        $user = $request->user();
        $cart = $user->cart()->with('cartItems.cake')->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        DB::beginTransaction();
        try {
            // Calculate total amount
            $totalAmount = $cart->cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'delivery_address' => $validated['delivery_address'],
                'delivery_phone' => $validated['delivery_phone'],
                'delivery_date' => $validated['delivery_date'] ?? now()->addDays(2),
                'special_instructions' => $validated['special_instructions'],
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // Create order items from cart items
            foreach ($cart->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'cake_id' => $cartItem->cake_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'customization' => $cartItem->customization,
                ]);
            }

            // Clear cart
            $cart->cartItems()->delete();

            DB::commit();

            return new OrderResource($order->load(['user', 'orderItems.cake']));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to create order'], 500);
        }
    }

    public function show(Order $order)
    {
        // Ensure users can only see their own orders
        if (auth()->user()->isCustomer() && $order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return new OrderResource($order->load(['user', 'orderItems.cake']));
    }

    public function update(Request $request, Order $order)
    {
        // Only admins can update orders
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'status' => 'in:pending,confirmed,preparing,ready,delivered,cancelled',
            'payment_status' => 'in:pending,paid,failed',
            'delivery_date' => 'nullable|date',
            'special_instructions' => 'nullable|string',
        ]);

        $order->update($validated);
        return new OrderResource($order->load(['user', 'orderItems.cake']));
    }

    public function destroy(Order $order)
    {
        // Only allow deletion if order is pending and user owns it or user is admin
        if (!auth()->user()->isAdmin() && 
            ($order->user_id !== auth()->id() || $order->status !== 'pending')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order->delete();
        return response()->json(['message' => 'Order cancelled successfully']);
    }
}