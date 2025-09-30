<?php

namespace App\Livewire;

use App\Models\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationSystem extends Component
{
    use WithPagination;

    public $showNotifications = false;
    public $unreadCount = 0;

    protected $listeners = ['notificationCreated' => 'updateNotifications'];

    public function mount()
    {
        $this->updateUnreadCount();
    }

    public function render()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(10);

        return view('livewire.notification-system', compact('notifications'))
        ->layout('layouts.app');
    }

    public function toggleNotifications()
    {
        $this->showNotifications = !$this->showNotifications;
        if ($this->showNotifications) {
            $this->updateUnreadCount();
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);
        if ($notification && !$notification->read_at) {
            $notification->update(['read_at' => now()]);
            $this->updateUnreadCount();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);
        $this->unreadCount = 0;
    }

    public function deleteNotification($notificationId)
    {
        auth()->user()->notifications()->find($notificationId)?->delete();
        $this->updateUnreadCount();
    }

    public function deleteAllRead()
    {
        auth()->user()->notifications()->whereNotNull('read_at')->delete();
    }

    private function updateUnreadCount()
    {
        $this->unreadCount = auth()->user()->notifications()->whereNull('read_at')->count();
    }

    public function updateNotifications()
    {
        $this->updateUnreadCount();
        $this->render();
    }

    /**
     * Create a new notification
     */
    public static function createNotification($userId, $type, $title, $message, $data = [])
    {
        Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);

        // Dispatch Livewire event to update UI
        \Livewire\Livewire::dispatch('notificationCreated');
    }

    /**
     * Send order status notification
     */
    public static function sendOrderStatusNotification($order)
    {
        $statusMessages = [
            'pending' => 'Your order has been received and is pending confirmation.',
            'confirmed' => 'Your order has been confirmed and will be prepared soon.',
            'preparing' => 'Your order is being prepared by our bakers.',
            'ready' => 'Your order is ready for delivery/pickup.',
            'delivered' => 'Your order has been successfully delivered.',
            'cancelled' => 'Your order has been cancelled.'
        ];

        $message = $statusMessages[$order->status] ?? 'Your order status has been updated.';

        self::createNotification(
            $order->user_id,
            'order_status',
            'Order Update - #' . $order->id,
            $message,
            [
                'order_id' => $order->id,
                'status' => $order->status,
                'total_amount' => $order->total_amount
            ]
        );
    }

    /**
     * Send low stock notification to admin
     */
    public static function sendLowStockNotification($cake)
    {
        // Get all admin users
        $adminUsers = \App\Models\User::where('user_type', 'admin')->get();

        foreach ($adminUsers as $admin) {
            self::createNotification(
                $admin->id,
                'low_stock',
                'Low Stock Alert',
                "Product '{$cake->name}' is running low on stock. Current quantity: {$cake->stock_quantity}",
                [
                    'cake_id' => $cake->id,
                    'cake_name' => $cake->name,
                    'stock_quantity' => $cake->stock_quantity
                ]
            );
        }
    }

    /**
     * Send new order notification to admin
     */
    public static function sendNewOrderNotification($order)
    {
        $adminUsers = \App\Models\User::where('user_type', 'admin')->get();

        foreach ($adminUsers as $admin) {
            self::createNotification(
                $admin->id,
                'new_order',
                'New Order Received',
                "New order #${order->id} from {$order->user->name} - Rs. " . number_format($order->total_amount, 2),
                [
                    'order_id' => $order->id,
                    'customer_name' => $order->user->name,
                    'total_amount' => $order->total_amount
                ]
            );
        }
    }
}