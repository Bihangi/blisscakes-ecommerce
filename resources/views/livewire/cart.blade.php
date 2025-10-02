<div>
    @section('title', 'My Cart - BlissCakes')
    
    <div class="min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-16 xl:px-24 py-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">Shopping Cart</h2>

            @if($cartItems->isEmpty())
                <div class="bg-white rounded-2xl shadow-md p-16 text-center">
                    <div class="text-6xl mb-4">🛒</div>
                    <p class="text-xl text-gray-600 mb-6">Your cart is empty</p>
                    <a href="{{ route('cakes.browse') }}" class="inline-block bg-gray-900 hover:bg-gray-800 text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">
                        Browse Cakes
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                            <!-- Table Header -->
                            <div class="hidden md:grid md:grid-cols-12 bg-gray-100 border-b px-6 py-4 font-semibold text-gray-700">
                                <div class="col-span-5">Product</div>
                                <div class="col-span-3 text-center">Quantity</div>
                                <div class="col-span-3 text-center">Price</div>
                                <div class="col-span-1"></div>
                            </div>

                            <!-- Cart Items -->
                            <div class="divide-y">
                                @foreach($cartItems as $item)
                                    <div class="p-6 hover:bg-gray-50 transition">
                                        <!-- Mobile Layout -->
                                        <div class="md:hidden space-y-4">
                                            <div class="flex gap-4">
                                                <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                                    @if($item->cake->image)
                                                        <img src="/storage/{{ $item->cake->image }}" alt="{{ $item->cake->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                            <i class="fas fa-birthday-cake text-2xl"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="font-semibold text-gray-900 text-lg">{{ $item->cake->name }}</h3>
                                                    <p class="text-sm text-gray-500">{{ $item->cake->size ?? 'Standard' }}</p>
                                                    <p class="text-lg font-semibold text-gray-900 mt-1">Rs. {{ number_format($item->cake->price, 2) }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" 
                                                            class="w-9 h-9 flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                                                        −
                                                    </button>
                                                    <span class="w-12 text-center font-semibold text-gray-900">{{ $item->quantity }}</span>
                                                    <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" 
                                                            class="w-9 h-9 flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                                                        +
                                                    </button>
                                                </div>
                                                <button wire:click="removeItem({{ $item->id }})" 
                                                        class="text-red-600 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Desktop Layout -->
                                        <div class="hidden md:grid md:grid-cols-12 gap-4 items-center">
                                            <!-- Product Info -->
                                            <div class="col-span-5 flex items-center gap-4">
                                                <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                                    @if($item->cake->image)
                                                        <img src="/storage/{{ $item->cake->image }}" alt="{{ $item->cake->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                            <i class="fas fa-birthday-cake text-xl"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900">{{ $item->cake->name }}</h3>
                                                    <p class="text-sm text-gray-500">{{ $item->cake->size ?? 'Standard' }}</p>
                                                </div>
                                            </div>

                                            <!-- Quantity Controls -->
                                            <div class="col-span-3 flex items-center justify-center gap-3">
                                                <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" 
                                                        class="w-9 h-9 flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                                                    −
                                                </button>
                                                <span class="w-12 text-center font-semibold text-gray-900">{{ $item->quantity }}</span>
                                                <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" 
                                                        class="w-9 h-9 flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                                                    +
                                                </button>
                                            </div>

                                            <!-- Price -->
                                            <div class="col-span-3 text-center">
                                                <p class="text-lg font-semibold text-gray-900">Rs. {{ number_format($item->subtotal, 2) }}</p>
                                            </div>

                                            <!-- Remove Button -->
                                            <div class="col-span-1 text-center">
                                                <button wire:click="removeItem({{ $item->id }})" 
                                                        class="text-red-600 hover:text-red-700 transition">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Clear Cart Button -->
                        <div class="mt-4">
                            <button wire:click="clearCart" 
                                    class="text-red-600 hover:text-red-700 font-medium flex items-center gap-2">
                                <i class="fas fa-trash-alt"></i>
                                Clear Cart
                            </button>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b">Order Summary</h3>

                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span class="font-medium text-gray-900">Rs. {{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Delivery</span>
                                    <span class="font-medium text-gray-900">Calculated at checkout</span>
                                </div>
                            </div>

                            <div class="border-t pt-4 mb-6">
                                <div class="flex justify-between text-lg font-bold text-gray-900">
                                    <span>Total</span>
                                    <span>Rs. {{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <a href="{{ route('checkout') }}" 
                               class="block w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-3 rounded-lg shadow-md hover:shadow-lg transition-all text-center">
                                Proceed to Checkout
                            </a>
                            
                            <a href="{{ route('cakes.browse') }}" 
                               class="block w-full mt-3 bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-medium py-3 rounded-lg transition-all text-center">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>