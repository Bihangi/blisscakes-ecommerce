<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Order Management</h1>

    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    {{-- Status Filter --}}
    <div class="mb-6">
        <select wire:model.live="statusFilter" class="border rounded px-4 py-2">
            <option value="">All Orders</option>
            @foreach($statuses as $status)
                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Order ID</th>
                    <th class="px-6 py-3 text-left">Customer</th>
                    <th class="px-6 py-3 text-left">Total</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Payment</th>
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">#{{ $order->id }}</td>
                        <td class="px-6 py-4">{{ $order->user->name }}</td>
                        <td class="px-6 py-4">Rs. {{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4">
                            <select wire:change="updateOrderStatus({{ $order->id }}, $event.target.value)" 
                                    class="border rounded px-2 py-1 text-sm">
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-sm rounded {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="viewOrder({{ $order->id }})" 
                                    class="text-blue-500 hover:text-blue-700">
                                View Details
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>

    {{-- Order Details Modal --}}
    @if($selectedOrder)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 max-w-3xl w-full max-h-screen overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Order #{{ $selectedOrder->id }}</h2>
                    <button wire:click="$set('selectedOrder', null)" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="font-bold mb-2">Customer Information</h3>
                        <p>Name: {{ $selectedOrder->user->name }}</p>
                        <p>Email: {{ $selectedOrder->user->email }}</p>
                        <p>Phone: {{ $selectedOrder->delivery_phone }}</p>
                    </div>

                    <div>
                        <h3 class="font-bold mb-2">Delivery Address</h3>
                        <p>{{ $selectedOrder->delivery_address }}</p>
                    </div>

                    <div>
                        <h3 class="font-bold mb-2">Order Items</h3>
                        @foreach($selectedOrder->items as $item)
                            <div class="flex justify-between py-2 border-b">
                                <span>{{ $item->cake->name }} x {{ $item->quantity }}</span>
                                <span>Rs. {{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        @endforeach
                        <div class="flex justify-between py-2 font-bold">
                            <span>Total</span>
                            <span>Rs. {{ number_format($selectedOrder->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>