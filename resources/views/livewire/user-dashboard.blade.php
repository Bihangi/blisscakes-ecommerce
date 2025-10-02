<div class="min-h-screen bg-gray-50 py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-16 xl:px-24">
        
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">My Orders</h2>
            <p class="text-gray-600">Track and manage your cake orders</p>
        </div>

        <!-- Success/Error Messages -->
        @if (session()->has('message'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span>{{ session('message') }}</span>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if ($orders->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-md p-16 text-center">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No orders yet</h3>
                <p class="text-gray-600 mb-6">Start shopping and place your first order!</p>
                <a href="{{ route('cakes.browse') }}" class="inline-block bg-gray-900 hover:bg-gray-800 text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">
                    Browse Cakes
                </a>
            </div>
        @else
            <!-- Orders List -->
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <!-- Order Header -->
                        <div class="bg-gray-100 px-6 py-4 border-b">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Order #{{ $order->id }}</h3>
                                    <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="px-4 py-1.5 rounded-full text-sm font-semibold
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'preparing') bg-orange-100 text-orange-800
                                        @elseif($order->status === 'ready') bg-purple-100 text-purple-800
                                        @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="p-6">
                            <div class="space-y-4 mb-6">
                                @foreach($order->orderItems as $item)
                                    <div class="flex items-center gap-4 pb-4 border-b last:border-0">
                                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                            @if($item->cake->image)
                                                <img src="/storage/{{ $item->cake->image }}" alt="{{ $item->cake->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                    <i class="fas fa-birthday-cake text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900">{{ $item->cake->name }}</h4>
                                            <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                            @if($item->customization)
                                                <p class="text-sm text-gray-600 mt-1">
                                                    <i class="fas fa-tag text-gray-400 mr-1"></i>
                                                    {{ $item->customizationText }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-900">Rs. {{ number_format($item->subtotal, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Order Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t">
                                <div>
                                    <h5 class="font-semibold text-gray-900 mb-2">Delivery Information</h5>
                                    <p class="text-sm text-gray-600"><i class="fas fa-map-marker-alt w-5"></i> {{ $order->delivery_address }}</p>
                                    <p class="text-sm text-gray-600"><i class="fas fa-phone w-5"></i> {{ $order->delivery_phone }}</p>
                                    <p class="text-sm text-gray-600"><i class="fas fa-calendar w-5"></i> {{ \Carbon\Carbon::parse($order->delivery_date)->format('M d, Y') }}</p>
                                    @if($order->special_instructions)
                                        <p class="text-sm text-gray-600 mt-2"><i class="fas fa-comment w-5"></i> {{ $order->special_instructions }}</p>
                                    @endif
                                </div>
                                <div class="flex flex-col justify-between">
                                    <div>
                                        <h5 class="font-semibold text-gray-900 mb-2">Order Total</h5>
                                        <p class="text-2xl font-bold text-gray-900">Rs. {{ number_format($order->total_amount, 2) }}</p>
                                    </div>
                                    
                                    @if($order->status === 'pending')
                                        <div class="flex gap-2 mt-4">
                                            <button wire:click="editOrder({{ $order->id }})" 
                                                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </button>
                                            
                                            @if($this->canCancelOrder($order))
                                                <button wire:click="deleteOrder({{ $order->id }})" 
                                                        onclick="return confirm('Are you sure you want to cancel this order?')"
                                                        class="flex-1 bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg font-medium transition-colors">
                                                    <i class="fas fa-times mr-1"></i> Cancel
                                                </button>
                                            @else
                                                <button disabled 
                                                        class="flex-1 bg-gray-100 text-gray-400 px-4 py-2 rounded-lg font-medium cursor-not-allowed"
                                                        title="Orders can only be cancelled 24 hours before delivery">
                                                    <i class="fas fa-ban mr-1"></i> Cannot Cancel
                                                </button>
                                            @endif
                                        </div>
                                        
                                        @if(!$this->canCancelOrder($order))
                                            <div class="mt-3 bg-amber-50 border border-amber-200 rounded-lg p-3">
                                                <p class="text-xs text-amber-800">
                                                    <i class="fas fa-info-circle mr-1"></i> 
                                                    Cancellation is only available 24 hours before the delivery date ({{ \Carbon\Carbon::parse($order->delivery_date)->format('M d, Y') }}).
                                                </p>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Edit Order Modal -->
        @if($editingOrder)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6 border-b">
                        <h3 class="text-2xl font-bold text-gray-900">Edit Order #{{ $editingOrder->id }}</h3>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Delivery Address *</label>
                            <textarea wire:model="deliveryAddress" rows="3" 
                                      class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition"></textarea>
                            @error('deliveryAddress') 
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Phone Number *</label>
                            <input type="tel" wire:model="deliveryPhone" 
                                   class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition">
                            @error('deliveryPhone') 
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Special Instructions</label>
                            <textarea wire:model="specialInstructions" rows="3" 
                                      class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition"></textarea>
                        </div>
                    </div>

                    <div class="p-6 border-t flex gap-3 justify-end">
                        <button wire:click="cancelEdit" 
                                class="px-6 py-2 border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button wire:click="updateOrder" 
                                class="px-6 py-2 bg-gray-900 hover:bg-gray-800 text-white font-medium rounded-lg transition-colors">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>