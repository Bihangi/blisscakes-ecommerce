<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\CartItem;
use Livewire\Component;

class CartManagement extends Component
{
    public $showCheckoutForm = false;
    public $deliveryAddress = '';
    public $deliveryPhone = '';
    public $deliveryDate = '';
    public $specialInstructions = '';

    protected $listeners = ['cart-updated' => 'render'];

    protected $rules = [
        'deliveryAddress' => 'required|string|max:500',
        'deliveryPhone' => 'required|string|max:20',
        'deliveryDate' => 'nullable|date|after:today',
        'specialInstructions' => 'nullable|string|max:500'
    ];

    public function render()
    {
        if (!auth()->check()) {
            return view('livewire.enhanced-cart', [
                'cartItems' => collect(),
                'total' => 0
            ]);
        }

        $cart = auth()->user()->cart;
        $cartItems = $cart ? $cart->cartItems()->with('cake')->get() : collect();
        $total = $cartItems->sum('subtotal');

        return view('livewire.cart', compact('cartItems', 'total'))
        -> layout('layouts.app');
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeItem($cartItemId);
            return;
        }

        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->update(['quantity' => $quantity]);
        
        session()->flash('message', 'Cart updated successfully!');
        $this->dispatch('cart-updated');
    }

    public function removeItem($cartItemId)
    {
        CartItem::findOrFail($cartItemId)->delete();
        session()->flash('message', 'Item removed from cart!');
        $this->dispatch('cart-updated');
    }

    public function clearCart()
    {
        $cart = auth()->user()->cart;
        if ($cart) {
            $cart->cartItems()->delete();
        }
        session()->flash('message', 'Cart cleared successfully!');
        $this->dispatch('cart-updated');
    }

    public function showCheckout()
    {
        $this->showCheckoutForm = true;
    }

    public function hideCheckout()
    {
        $this->showCheckoutForm = false;
        $this->resetCheckoutForm();
    }

    public function checkout()
    {
        $this->validate();

        $cart = auth()->user()->cart;
        if (!$cart || $cart->cartItems->isEmpty()) {
            session()->flash('error', 'Your cart is empty!');
            return;
        }

        // Calculate total
        $total = $cart->cartItems->sum('subtotal');

        // Create order
        $order = auth()->user()->orders()->create([
            'total_amount' => $total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'delivery_address' => $this->deliveryAddress,
            'delivery_phone' => $this->deliveryPhone,
            'delivery_date' => $this->deliveryDate ?: null,
            'special_instructions' => $this->specialInstructions,
        ]);

        // Create order items
        foreach ($cart->cartItems as $cartItem) {
            $order->orderItems()->create([
                'cake_id' => $cartItem->cake_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'customization' => $cartItem->customization,
            ]);
        }

        // Clear cart
        $cart->cartItems()->delete();

        session()->flash('message', 'Order placed successfully! Order #' . $order->id);
        $this->hideCheckout();
        $this->dispatch('cart-updated');
        
        return redirect()->route('dashboard');
    }

    private function resetCheckoutForm()
    {
        $this->deliveryAddress = '';
        $this->deliveryPhone = '';
        $this->deliveryDate = '';
        $this->specialInstructions = '';
    }

    public function getCartCount()
    {
        if (!auth()->check()) return 0;
        
        $cart = auth()->user()->cart;
        return $cart ? $cart->cartItems->sum('quantity') : 0;
    }
}