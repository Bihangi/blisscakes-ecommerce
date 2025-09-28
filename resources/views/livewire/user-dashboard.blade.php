<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">My Orders</h3>
                
                @if(!$showCreateForm)
                    <button wire:click="showCreateForm" 
                            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                        Create New Order
                    </button>
                @endif
            </div>

            <!-- Create Order Form -->
            @if($showCreateForm)
                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Create New Order</h4>
                    
                    <form wire:submit.prevent="createOrder" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="selectedCake" class="block text-sm font-medium text-gray-700">Select Cake</label>
                            <select wire:model="selectedCake" id="selectedCake" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Choose a cake...</option>
                                @foreach($cakes as $cake)
                                    <option value="{{ $cake->id }}">{{ $cake->name }} - Rs. {{ number_format($cake->price, 2) }}</option>
                                @endforeach
                            </select>
                            @error('selectedCake') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" wire:model="quantity" id="quantity" min="1" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="customMessage" class="block text-sm font-medium text-gray-700">Custom Message (Optional)</label>
                            <input type="text" wire:model="customMessage" id="customMessage" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('customMessage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="deliveryPhone" class="block text-sm font-medium text-gray-700">Delivery Phone</label>
                            <input type="text" wire:model="deliveryPhone" id="deliveryPhone" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('deliveryPhone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="deliveryAddress" class="block text-sm font-medium text-gray-700">Delivery Address</label>
                            <textarea wire:model="deliveryAddress" id="deliveryAddress" rows="3" 
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                            @error('deliveryAddress') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="specialInstructions" class="block text-sm font-medium text-gray-700">Special Instructions (Optional)</label>
                            <textarea wire:model="specialInstructions" id="specialInstructions" rows="2" 
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                            @error('specialInstructions') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2 flex justify-end space-x-3">
                            <button type="button" wire:click="hideCreateForm" 
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Orders Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    @foreach($order->orderItems as $item)
                                        <div>{{ $item->cake->name }} ({{ $item->quantity }}x)</div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rs. {{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'preparing') bg-orange-100 text-orange-800
                                        @elseif($order->status === 'ready') bg-purple-100 text-purple-800
                                        @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($order->status === 'pending')
                                        @if($editingOrder && $editingOrder->id === $order->id)
                                            <button wire:click="updateOrder" 
                                                    class="text-green-600 hover:text-green-900 mr-2">Save</button>
                                            <button wire:click="cancelEdit" 
                                                    class="text-gray-600 hover:text-gray-900 mr-2">Cancel</button>
                                        @else
                                            <button wire:click="editOrder({{ $order->id }})" 
                                                    class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</button>
                                        @endif
                                        <button wire:click="deleteOrder({{ $order->id }})" 
                                                class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Are you sure you want to cancel this order?')">Cancel</button>
                                    @endif
                                </td>
                            </tr>
                            
                            @if($editingOrder && $editingOrder->id === $order->id)
                                <tr>
                                    <td colspan="6" class="px-6 py-4 bg-gray-50">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Delivery Address</label>
                                                <textarea wire:model="deliveryAddress" rows="2" 
                                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Delivery Phone</label>
                                                <input type="text" wire:model="deliveryPhone" 
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-medium text-gray-700">Special Instructions</label>
                                                <textarea wire:model="specialInstructions" rows="2" 
                                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>