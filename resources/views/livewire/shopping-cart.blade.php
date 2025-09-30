<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            @foreach($cartItems as $item)
                <div class="flex items-center border-b py-4 last:border-b-0">
                    @if($item->cake->image)
                        <img src="{{ asset('storage/' . $item->cake->image) }}" alt="{{ $item->cake->name }}" 
                             class="w-20 h-20 object-cover rounded mr-4">
                    @endif
                    
                    <div class="flex-1">
                        <h3 class="font-bold">{{ $item->cake->name }}</h3>
                        <p class="text-gray-600">Rs. {{ number_format($item->price, 2) }}</p>
                        @if($item->customization)
                            <p class="text-sm text-gray-500">Custom: {{ json_encode($item->customization) }}</p>
                        @endif
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" 
                                    class="bg-gray-200 px-3 py-1 rounded">-</button>
                            <span class="font-bold">{{ $item->quantity }}</span>
                            <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" 
                                    class="bg-gray-200 px-3 py-1 rounded">+</button>
                        </div>
                        
                        <span class="font-bold">Rs. {{ number_format($item->subtotal, 2) }}</span>
                        
                        <button wire:click="removeItem({{ $item->id }})" 
                                class="text-red-500 hover:text-red-700">
                            Remove
                        </button>
                    </div>
                </div>
            @endforeach

            <div class="mt-6 pt-6 border-t">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xl font-bold">Total:</span>
                    <span class="text-2xl font-bold text-pink-600">Rs. {{ number_format($total, 2) }}</span>
                </div>
                
                <div class="flex space-x-4">
                    <button wire:click="clearCart" class="flex-1 bg-gray-500 text-white py-3 rounded hover:bg-gray-600">
                        Clear Cart
                    </button>
                    <a href="{{ route('checkout') }}" class="flex-1 bg-pink-500 text-white py-3 rounded text-center hover:bg-pink-600">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <p class="text-gray-500 text-lg mb-4">Your cart is empty</p>
            <a href="{{ route('cakes.browse') }}" class="bg-pink-500 text-white px-6 py-3 rounded hover:bg-pink-600">
                Continue Shopping
            </a>
        </div>
    @endif
</div>