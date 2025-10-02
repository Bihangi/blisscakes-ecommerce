<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Order Management</h1>

    {{-- Flash Messages --}}
    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Filter Section --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <select wire:model.live="statusFilter" class="border rounded px-4 py-2 pr-8">
                <option value="">All Orders</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
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
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">#{{ $order->id }}</td>
                        <td class="px-6 py-4">{{ $order->user->username }}</td>
                        <td class="px-6 py-4">Rs. {{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4">
                            <select wire:change="updateOrderStatus({{ $order->id }}, $event.target.value)" 
                                    class="border rounded px-2 py-1 pr-8 text-sm">
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-6 py-4">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="viewOrder({{ $order->id }})" 
                                    class="text-blue-500 hover:text-blue-700 font-semibold">
                                View
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>

    {{-- Order Details Modal --}}
    @if($selectedOrder)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-3xl w-full max-h-screen overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Order #{{ $selectedOrder->id }}</h2>
                    <button wire:click="closeOrderModal" class="text-gray-500 hover:text-gray-700">
                        ✕
                    </button>
                </div>

                {{-- Customer Info --}}
                <div class="mb-4">
                    <h3 class="font-bold mb-2">Customer Information</h3>
                    <p><span class="font-semibold">Name:</span> {{ $selectedOrder->user->name }}</p>
                    <p><span class="font-semibold">Email:</span> {{ $selectedOrder->user->email }}</p>
                    <p><span class="font-semibold">Phone:</span> {{ $selectedOrder->delivery_phone }}</p>
                </div>

                {{-- Address --}}
                <div class="mb-4">
                    <h3 class="font-bold mb-2">Delivery Address</h3>
                    <p>{{ $selectedOrder->delivery_address }}</p>
                </div>

                {{-- Items --}}
                <div class="mb-4">
                    <h3 class="font-bold mb-2">Order Items</h3>
                    <div class="border rounded divide-y">
                        @if($selectedOrder && $selectedOrder->orderItems && $selectedOrder->orderItems->isNotEmpty())
                            @foreach($selectedOrder->orderItems as $item)
                                <div class="flex justify-between px-3 py-2">
                                    <span>{{ $item->cake->name }} x {{ $item->quantity }}</span>
                                    <span>Rs. {{ number_format($item->subtotal, 2) }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="px-3 py-2 text-gray-500">No items in this order.</p>
                        @endif
                        <div class="flex justify-between px-3 py-2 font-bold bg-gray-50">
                            <span>Total</span>
                            <span>Rs. {{ number_format($selectedOrder->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button wire:click="closeOrderModal" 
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
