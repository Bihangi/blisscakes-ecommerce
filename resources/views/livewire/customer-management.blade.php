<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Customer Management</h1>

    {{-- Search --}}
    <div class="mb-6">
        <input type="text" wire:model.live="search" placeholder="Search customers..." 
               class="border rounded px-4 py-2 w-full md:w-96">
    </div>

    {{-- Customers Table --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Phone</th>
                    <th class="px-6 py-3 text-left">Joined</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">{{ $customer->name }}</td>
                        <td class="px-6 py-4">{{ $customer->email }}</td>
                        <td class="px-6 py-4">{{ $customer->phone ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $customer->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="viewCustomer({{ $customer->id }})" 
                                    class="text-blue-500 hover:text-blue-700 mr-3">
                                View
                            </button>
                            <button wire:click="deleteCustomer({{ $customer->id }})" 
                                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                    class="text-red-500 hover:text-red-700">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $customers->links() }}
    </div>

    {{-- Customer Details Modal --}}
    @if($selectedCustomer)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 max-w-2xl w-full max-h-screen overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Customer Details</h2>
                    <button wire:click="$set('selectedCustomer', null)" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="font-bold">Personal Information</h3>
                        <p>Name: {{ $selectedCustomer->name }}</p>
                        <p>Email: {{ $selectedCustomer->email }}</p>
                        <p>Phone: {{ $selectedCustomer->phone ?? 'N/A' }}</p>
                        <p>Address: {{ $selectedCustomer->address ?? 'N/A' }}</p>
                        <p>Member Since: {{ $selectedCustomer->created_at->format('F d, Y') }}</p>
                    </div>

                    <div>
                        <h3 class="font-bold mb-2">Recent Orders</h3>
                        @if($selectedCustomer->orders->count() > 0)
                            @foreach($selectedCustomer->orders as $order)
                                <div class="flex justify-between py-2 border-b">
                                    <span>Order #{{ $order->id }}</span>
                                    <span>Rs. {{ number_format($order->total_amount, 2) }}</span>
                                    <span class="text-sm">{{ $order->status }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500">No orders yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>