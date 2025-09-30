<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;
use App\Models\Cake;
use App\Models\Category;

class AdminDashboard extends Component
{
    public $stats;
    public $recentOrders;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'total_customers' => User::where('user_type', 'customer')->count(),
            'total_cakes' => Cake::count(),
            'available_cakes' => Cake::where('is_available', true)->count(),
            'total_categories' => Category::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
        ];

        $this->recentOrders = Order::with(['user', 'orderItems.cake'])
            ->latest()
            ->limit(10)
            ->get();
    }

    public function updateOrderStatus($orderId, $status)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['status' => $status]);
            $this->loadStats();
            session()->flash('message', 'Order status updated successfully.');
        }
    }

    public function render()
    {
        return view('livewire.admin-dashboard') ->layout('layouts.app');
    }
}