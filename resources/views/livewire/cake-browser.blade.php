<div class="min-h-screen bg-gradient-to-b from-white to-rose-50">
    <div class="px-4 md:px-16 py-10">
        <div class="flex flex-col md:flex-row gap-10">

            <!-- Filter Sidebar -->
            <div class="w-full md:w-1/4 flex justify-center md:block">
                <aside class="bg-white border-2 border-rose-200 p-6 rounded-2xl shadow-lg w-full max-w-sm sticky top-24 h-fit">
                    <h3 class="text-xl font-bold mb-6 tracking-wide uppercase text-center text-stone-800 border-b-2 border-rose-300 pb-3">
                        Filter by Category
                    </h3>
                    
                    <!-- Category Filter -->
                    <form class="space-y-3">
                        @foreach($categories as $category)
                            <label class="flex items-center space-x-3 cursor-pointer hover:bg-rose-50 p-2 rounded-lg transition group">
                                <input 
                                    type="checkbox" 
                                    wire:model.live="categoryFilter" 
                                    value="{{ $category->id }}" 
                                    class="accent-rose-500 w-5 h-5 rounded focus:ring-2 focus:ring-rose-400"
                                >
                                <span class="text-sm font-medium text-gray-700 group-hover:text-rose-600 transition">
                                    {{ $category->name }}
                                </span>
                            </label>
                        @endforeach
                    </form>

                    <div class="pt-6 mt-6 border-t border-rose-200 text-center">
                        <button 
                            wire:click="clearFilters" 
                            class="w-full bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white px-4 py-2.5 rounded-full text-sm font-semibold shadow-md hover:shadow-lg transition-all transform hover:scale-105">
                            Clear All Filters
                        </button>
                    </div>
                </aside>
            </div>

            <!-- Product Grid -->
            <div class="w-full md:w-3/4">
                <!-- Header Section -->
                <div class="flex justify-center mb-10 text-center">
                    <div class="max-w-3xl">
                        <h2 class="text-4xl md:text-5xl font-bold mb-5 tracking-wide text-stone-800">
                            Order Now
                        </h2>
                        <p class="text-gray-600 text-base md:text-lg leading-relaxed">
                            Baked with love, just like home. Our cakes bring the warmth of homemade goodness
                            with a delicious variety to suit every heart and taste.
                            <span class="block mt-2 font-semibold text-stone-800">
                                We never compromise on quality
                            </span>
                            — every cake is baked to perfection.
                        </p>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($cakes as $cake)
                        <div class="bg-white border-2 border-rose-100 rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 p-5 text-center group hover:scale-105">
                            <!-- Image Container -->
                            <div class="relative overflow-hidden rounded-xl mb-4 bg-gray-100">
                                @if($cake->image)
                                    <img 
                                        src="{{ asset('storage/' . $cake->image) }}" 
                                        alt="{{ $cake->name }}" 
                                        class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500"
                                    >
                                @else
                                    <div class="w-full h-56 flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                        <i class="fas fa-birthday-cake text-6xl text-gray-300"></i>
                                    </div>
                                @endif
                                
                                <!-- Availability Badge -->
                                @if($cake->is_available)
                                    <span class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                                        Available
                                    </span>
                                @else
                                    <span class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                                        Out of Stock
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Cake Info -->
                            <h3 class="text-lg font-bold text-stone-800 mb-2 group-hover:text-rose-600 transition">
                                {{ $cake->name }}
                            </h3>
                            
                            <p class="text-sm text-gray-500 mb-1">
                                {{ $cake->size ?? 'Standard Size' }}
                            </p>
                            
                            @if($cake->category)
                                <span class="inline-block bg-rose-100 text-rose-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">
                                    {{ $cake->category->name }}
                                </span>
                            @endif
                            
                            <p class="text-2xl font-bold text-stone-800 mt-3 mb-4">
                                Rs. {{ number_format($cake->price, 2) }}
                            </p>
                            
                            <!-- View Product Button -->
                            <button 
                                wire:click="viewCakeDetails({{ $cake->id }})" 
                                class="w-full bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:shadow-xl transition-all transform hover:scale-105">
                                View Product
                            </button>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20">
                            <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-medium">No cakes available for the selected filters.</p>
                            <button 
                                wire:click="clearFilters" 
                                class="mt-4 text-rose-600 hover:text-rose-700 font-semibold underline">
                                Clear filters and view all cakes
                            </button>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-10">
                    {{ $cakes->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Cake Details Modal -->
    @if($showCakeDetails && $selectedCake)
        <div class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4" wire:click="hideCakeDetails">
            <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl" wire:click.stop>
                <!-- Modal Header -->
                <div class="sticky top-0 bg-white border-b border-gray-200 p-6 flex justify-between items-center z-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-stone-800">{{ $selectedCake->name }}</h2>
                    <button 
                        wire:click="hideCakeDetails" 
                        class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-3xl"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 md:p-8">
                    <!-- Image -->
                    @if($selectedCake->image)
                        <div class="mb-6 rounded-xl overflow-hidden shadow-lg">
                            <img 
                                src="{{ asset('storage/' . $selectedCake->image) }}" 
                                alt="{{ $selectedCake->name }}" 
                                class="w-full h-80 object-cover"
                            >
                        </div>
                    @endif

                    <!-- Category & Size -->
                    <div class="flex gap-3 mb-4">
                        @if($selectedCake->category)
                            <span class="bg-rose-100 text-rose-700 text-sm font-semibold px-4 py-2 rounded-full">
                                {{ $selectedCake->category->name }}
                            </span>
                        @endif
                        <span class="bg-gray-100 text-gray-700 text-sm font-semibold px-4 py-2 rounded-full">
                            {{ $selectedCake->size ?? 'Standard Size' }}
                        </span>
                    </div>

                    <!-- Description -->
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        {{ $selectedCake->description ?? 'A delicious handcrafted cake made with premium ingredients.' }}
                    </p>

                    <!-- Price -->
                    <div class="bg-gradient-to-r from-rose-50 to-pink-50 p-6 rounded-xl mb-6">
                        <p class="text-sm text-gray-600 mb-1">Price</p>
                        <p class="text-4xl font-bold text-rose-600">
                            Rs. {{ number_format($selectedCake->price, 2) }}
                        </p>
                    </div>

                    <!-- Quantity -->
                    <div class="mb-6">
                        <label class="block font-bold text-stone-800 mb-3">Quantity</label>
                        <div class="flex items-center gap-4">
                            <button 
                                wire:click="decrementQuantity" 
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold w-12 h-12 rounded-full transition">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input 
                                type="number" 
                                wire:model="quantity" 
                                min="1" 
                                class="border-2 border-gray-300 rounded-lg px-4 py-3 w-24 text-center text-lg font-semibold focus:ring-2 focus:ring-rose-400 focus:border-rose-400"
                            >
                            <button 
                                wire:click="incrementQuantity" 
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold w-12 h-12 rounded-full transition">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <button 
                        wire:click="addToCart({{ $selectedCake->id }})" 
                        class="w-full bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white font-bold px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:scale-105 text-lg">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>