<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class Checkout extends Component
{
    public $deliveryMethod = 'delivery';
    public $fullName;
    public $phone;
    public $address;
    public $city;
    public $postalCode;
    public $deliveryDate;
    public $specialInstructions;
    
    public $cartItems;
    public $subtotal = 0;
    public $total = 0;

    public function mount()
    {
        $cart = Auth::user()->cart;
        
        if (!$cart || $cart->cartItems->isEmpty()) {
            session()->flash('error', 'Your cart is empty!');
            return redirect()->route('cart');
        }
        
        $this->cartItems = $cart->cartItems;
        $this->calculateTotals();
        
        // Pre-fill user data
        $this->fullName = Auth::user()->name;
        $this->phone = Auth::user()->phone ?? '';
        $this->address = Auth::user()->address ?? '';
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'deliveryMethod') {
            $this->calculateTotals();
        }
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->cartItems->sum('subtotal');
        $this->total = $this->subtotal + ($this->deliveryMethod === 'delivery' ? 500 : 0);
    }

    public function placeOrder()
    {
        $rules = [
            'deliveryMethod' => 'required|in:delivery,pickup',
            'fullName' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'deliveryDate' => 'required|date|after:today',
        ];

        if ($this->deliveryMethod === 'delivery') {
            $rules['address'] = 'required|string';
            $rules['city'] = 'required|string|max:100';
        }

        $this->validate($rules);

        try {
            DB::beginTransaction();

            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $this->total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'delivery_address' => $this->deliveryMethod === 'delivery' 
                    ? $this->address . ', ' . $this->city . ($this->postalCode ? ', ' . $this->postalCode : '')
                    : 'Store Pickup',
                'delivery_phone' => $this->phone,
                'delivery_date' => $this->deliveryDate,
                'special_instructions' => $this->specialInstructions,
            ]);

            // Create order items
            foreach ($this->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'cake_id' => $cartItem->cake_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'customization' => $cartItem->customization,
                ]);
            }

            // Clear the cart
            $cart = Auth::user()->cart;
            $cart->cartItems()->delete();

            DB::commit();

            session()->flash('success', 'Order placed successfully! Order #' . $order->id);
            
            return redirect()->route('orders');

        } catch (\Exception $e) {
            DB::rollBack();
            
            session()->flash('error', 'Failed to place order. Please try again.');
            
            // Log the error for debugging
            \Log::error('Order placement failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.checkout')->layout('layouts.frontend');
    }
}