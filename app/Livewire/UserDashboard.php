<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Cake;
use Illuminate\Support\Facades\Http;

class UserDashboard extends Component
{
    public $orders;
    public $cakes;
    public $showCreateForm = false;
    public $editingOrder = null;

    // Form fields
    public $selectedCake = '';
    public $quantity = 1;
    public $customMessage = '';
    public $deliveryAddress = '';
    public $deliveryPhone = '';
    public $specialInstructions = '';

    protected $rules = [
        'selectedCake' => 'required|exists:cakes,id',
        'quantity' => 'required|integer|min:1',
        'deliveryAddress' => 'required|string|max:500',
        'deliveryPhone' => 'required|string|max:20',
        'customMessage' => 'nullable|string|max:200',
        'specialInstructions' => 'nullable|string|max:500',
    ];

    public function mount()
    {
        $this->loadOrders();
        $this->loadCakes();
    }

    public function loadOrders()
    {
        $this->orders = auth()->user()->orders()
            ->with(['orderItems.cake'])
            ->latest()
            ->get();
    }

    public function loadCakes()
    {
        $this->cakes = Cake::where('is_available', true)->get();
    }

    public function showCreateForm()
    {
        $this->showCreateForm = true;
        $this->resetForm();
    }

    public function hideCreateForm()
    {
        $this->showCreateForm = false;
        $this->resetForm();
    }

    public function createOrder()
    {
        $this->validate();

        try {
            // First, add item to cart via API
            $response = Http::withToken(auth()->user()->createToken('temp')->plainTextToken)
                ->post(config('app.url') . '/api/cart/items', [
                    'cake_id' => $this->selectedCake,
                    'quantity' => $this->quantity,
                    'customization' => $this->customMessage ? ['message' => $this->customMessage] : null,
                ]);

            if ($response->successful()) {
                // Then create order via API
                $orderResponse = Http::withToken(auth()->user()->createToken('temp')->plainTextToken)
                    ->post(config('app.url') . '/api/orders', [
                        'delivery_address' => $this->deliveryAddress,
                        'delivery_phone' => $this->deliveryPhone,
                        'special_instructions' => $this->specialInstructions,
                    ]);

                if ($orderResponse->successful()) {
                    session()->flash('message', 'Order placed successfully!');
                    $this->loadOrders();
                    $this->hideCreateForm();
                } else {
                    session()->flash('error', 'Failed to create order.');
                }
            } else {
                session()->flash('error', 'Failed to add item to cart.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while placing the order.');
        }
    }

    public function editOrder($orderId)
    {
        $this->editingOrder = $this->orders->find($orderId);
        if ($this->editingOrder && $this->editingOrder->status === 'pending') {
            $this->deliveryAddress = $this->editingOrder->delivery_address;
            $this->deliveryPhone = $this->editingOrder->delivery_phone;
            $this->specialInstructions = $this->editingOrder->special_instructions;
        }
    }

    public function updateOrder()
    {
        $this->validate([
            'deliveryAddress' => 'required|string|max:500',
            'deliveryPhone' => 'required|string|max:20',
            'specialInstructions' => 'nullable|string|max:500',
        ]);

        if ($this->editingOrder && $this->editingOrder->status === 'pending') {
            $this->editingOrder->update([
                'delivery_address' => $this->deliveryAddress,
                'delivery_phone' => $this->deliveryPhone,
                'special_instructions' => $this->specialInstructions,
            ]);

            session()->flash('message', 'Order updated successfully!');
            $this->loadOrders();
            $this->cancelEdit();
        }
    }

    public function cancelEdit()
    {
        $this->editingOrder = null;
        $this->resetForm();
    }

    public function deleteOrder($orderId)
    {
        $order = $this->orders->find($orderId);
        if ($order && $order->status === 'pending') {
            try {
                $response = Http::withToken(auth()->user()->createToken('temp')->plainTextToken)
                    ->delete(config('app.url') . "/api/orders/{$orderId}");

                if ($response->successful()) {
                    session()->flash('message', 'Order cancelled successfully!');
                    $this->loadOrders();
                } else {
                    session()->flash('error', 'Failed to cancel order.');
                }
            } catch (\Exception $e) {
                session()->flash('error', 'An error occurred while cancelling the order.');
            }
        }
    }

    private function resetForm()
    {
        $this->selectedCake = '';
        $this->quantity = 1;
        $this->customMessage = '';
        $this->deliveryAddress = '';
        $this->deliveryPhone = '';
        $this->specialInstructions = '';
    }

    public function render()
    {
        return view('livewire.user-dashboard') ->layout('layouts.app');
    }
}