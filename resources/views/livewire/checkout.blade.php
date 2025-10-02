
<div class="min-h-screen bg-gradient-to-b from-white to-rose-50 py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-16 xl:px-24">
        <h2 class="text-3xl md:text-4xl font-bold text-stone-800 mb-8 text-center tracking-wide">Checkout</h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <div class="bg-white border-2 border-rose-100 rounded-2xl shadow-lg p-6 md:p-8">
                    
                    <!-- Delivery Method Selection -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-stone-800 mb-4">Select Delivery Method</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio" wire:model.live="deliveryMethod" value="delivery" class="peer sr-only">
                                <div class="border-2 border-rose-200 rounded-xl p-4 peer-checked:border-rose-500 peer-checked:bg-rose-50 transition">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-r from-rose-400 to-pink-400 rounded-full flex items-center justify-center text-white">
                                            <i class="fas fa-truck text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-stone-800">Home Delivery</p>
                                            <p class="text-sm text-gray-600">Rs. 500.00</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input type="radio" wire:model.live="deliveryMethod" value="pickup" class="peer sr-only">
                                <div class="border-2 border-rose-200 rounded-xl p-4 peer-checked:border-rose-500 peer-checked:bg-rose-50 transition">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-r from-rose-400 to-pink-400 rounded-full flex items-center justify-center text-white">
                                            <i class="fas fa-shopping-bag text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-stone-800">Store Pickup</p>
                                            <p class="text-sm text-gray-600">Free</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('deliveryMethod') 
                            <span class="text-red-600 text-sm mt-2 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Delivery Form (Only shown when delivery is selected) -->
                    @if($deliveryMethod === 'delivery')
                        <div class="space-y-5 mb-8">
                            <h3 class="text-xl font-bold text-stone-800 mb-4">Delivery Details</h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-stone-800 mb-2">Full Name *</label>
                                    <input type="text" wire:model="fullName" 
                                           class="w-full border-2 border-rose-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition">
                                    @error('fullName') 
                                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-stone-800 mb-2">Phone Number *</label>
                                    <input type="tel" wire:model="phone" 
                                           class="w-full border-2 border-rose-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition">
                                    @error('phone') 
                                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> 
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-stone-800 mb-2">Delivery Address *</label>
                                <textarea wire:model="address" rows="3" 
                                          class="w-full border-2 border-rose-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition"
                                          placeholder="Street address, apartment, suite, etc."></textarea>
                                @error('address') 
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-stone-800 mb-2">City *</label>
                                    <input type="text" wire:model="city" 
                                           class="w-full border-2 border-rose-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition">
                                    @error('city') 
                                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-stone-800 mb-2">Postal Code</label>
                                    <input type="text" wire:model="postalCode" 
                                           class="w-full border-2 border-rose-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition">
                                    @error('postalCode') 
                                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> 
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Pickup Information (Only shown when pickup is selected) -->
                    @if($deliveryMethod === 'pickup')
                        <div class="bg-gradient-to-r from-rose-50 to-pink-50 border-2 border-rose-200 rounded-xl p-6 mb-8">
                            <h3 class="text-xl font-bold text-stone-800 mb-3">Store Pickup Information</h3>
                            <div class="space-y-2 text-gray-700">
                                <p><i class="fas fa-map-marker-alt text-rose-500 w-5"></i> <strong>Location:</strong> 123 Bakery Street, Colombo 03</p>
                                <p><i class="fas fa-clock text-rose-500 w-5"></i> <strong>Hours:</strong> 9:00 AM - 6:00 PM (Daily)</p>
                                <p><i class="fas fa-phone text-rose-500 w-5"></i> <strong>Contact:</strong> +94 77 123 4567</p>
                            </div>

                            <div class="mt-5 space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-stone-800 mb-2">Your Name *</label>
                                    <input type="text" wire:model="fullName" 
                                           class="w-full border-2 border-rose-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition">
                                    @error('fullName') 
                                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-stone-800 mb-2">Phone Number *</label>
                                    <input type="tel" wire:model="phone" 
                                           class="w-full border-2 border-rose-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition">
                                    @error('phone') 
                                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> 
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Common Fields -->
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-stone-800 mb-2">Delivery/Pickup Date *</label>
                            <input type="date" wire:model="deliveryDate" 
                                   class="w-full border-2 border-rose-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition">
                            @error('deliveryDate') 
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-stone-800 mb-2">Special Instructions</label>
                            <textarea wire:model="specialInstructions" rows="3" 
                                      class="w-full border-2 border-rose-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition"
                                      placeholder="Any special requests, cake message, dietary requirements, etc."></textarea>
                        </div>
                    </div>

                    <!-- Payment Method Notice -->
                    <div class="mt-8 bg-amber-50 border-2 border-amber-200 rounded-xl p-5">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-amber-600 text-xl mt-0.5"></i>
                            <div>
                                <h4 class="font-bold text-stone-800 mb-1">Payment Method: Cash on Delivery/Pickup</h4>
                                <p class="text-sm text-gray-700">Please keep the exact amount ready when you receive your order. We accept cash only at this time.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white border-2 border-rose-200 rounded-2xl shadow-lg p-6 sticky top-24">
                    <h3 class="text-2xl font-bold text-stone-800 mb-6 text-center border-b-2 border-rose-300 pb-3">Order Summary</h3>

                    <!-- Cart Items -->
                    <div class="space-y-3 mb-6 max-h-60 overflow-y-auto">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-3 pb-3 border-b border-rose-100">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($item->cake->image)
                                        <img src="/storage/{{ $item->cake->image }}" alt="{{ $item->cake->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <i class="fas fa-birthday-cake"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-sm text-stone-800">{{ $item->cake->name }}</p>
                                    <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                    <p class="text-sm font-semibold text-rose-600">Rs. {{ number_format($item->subtotal, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pricing -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-700 text-lg">
                            <span>Subtotal</span>
                            <span class="font-semibold">Rs. {{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 text-lg">
                            <span>{{ $deliveryMethod === 'delivery' ? 'Delivery Fee' : 'Pickup' }}</span>
                            <span class="font-semibold">Rs. {{ $deliveryMethod === 'delivery' ? '500.00' : '0.00' }}</span>
                        </div>
                        <div class="border-t-2 border-rose-200 pt-3 flex justify-between text-2xl font-bold text-stone-800">
                            <span>Total</span>
                            <span class="text-rose-600">Rs. {{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button wire:click="placeOrder" 
                            class="w-full bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-bold py-4 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:scale-105 text-lg">
                        <i class="fas fa-check-circle mr-2"></i>
                        Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>