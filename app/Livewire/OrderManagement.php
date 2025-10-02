<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderManagement extends Component
{
    use WithPagination;

    public $statusFilter = '';
    public $paymentStatusFilter = '';
    public $search = '';
    public $selectedOrder = null;
    public $showOrderDetails = false;

    public $statuses = [
        'pending',
        'confirmed',
        'preparing',
        'ready',
        'delivered',
        'cancelled',
    ];

    public function render()
    {
        $statuses = $this->statuses ?? [];
        
        $orders = Order::with(['user', 'orderItems.cake'])
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->paymentStatusFilter, function ($query) {
                $query->where('payment_status', $this->paymentStatusFilter);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('id', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(15);

        $orderStats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'confirmed_orders' => Order::where('status', 'confirmed')->count(),
            'preparing_orders' => Order::where('status', 'preparing')->count(),
            'ready_orders' => Order::where('status', 'ready')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'paid_orders' => Order::where('payment_status', 'paid')->count(),
            'pending_payments' => Order::where('payment_status', 'pending')->count(),
        ];

        return view('livewire.order-management', compact('orders', 'orderStats'));
    }

    public function updateOrderStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => $status]);
        
        session()->flash('message', "Order #{$orderId} status updated to {$status}");
    }

    public function updatePaymentStatus($orderId, $paymentStatus)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['payment_status' => $paymentStatus]);
        
        session()->flash('message', "Order #{$orderId} payment status updated to {$paymentStatus}");
    }

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::with(['user', 'orderItems.cake'])
            ->findOrFail($orderId);
        $this->showOrderDetails = true;
    }

    public function hideOrderDetails()
    {
        $this->showOrderDetails = false;
        $this->selectedOrder = null;
    }

    public function getStatusOptions()
    {
        return [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'preparing' => 'Preparing',
            'ready' => 'Ready',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];
    }

    public function getPaymentStatusOptions()
    {
        return [
            'pending' => 'Pending',
            'paid' => 'Paid',
            'failed' => 'Failed'
        ];
    }

    public function closeOrderModal()
    {
        $this->selectedOrder = null;
    }

}
