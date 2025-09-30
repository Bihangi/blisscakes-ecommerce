<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-4">Browse Our Cakes</h1>
        
        {{-- Search and Filters --}}
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" wire:model.live="search" placeholder="Search cakes..." 
                           class="w-full border rounded px-4 py-2">
                </div>
                
                <div>
                    <select wire:model.live="selectedCategory" class="w-full border rounded px-4 py-2">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <select wire:model.live="selectedFlavor" class="w-full border rounded px-4 py-2">
                        <option value="">All Flavors</option>
                        <option value="Chocolate">Chocolate</option>
                        <option value="Vanilla">Vanilla</option>
                        <option value="Strawberry">Strawberry</option>
                        <option value="Red Velvet">Red Velvet</option>
                    </select>
                </div>
                
                <div>
                    <button wire:click="clearFilters" class="w-full bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Cakes Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($cakes as $cake)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                @if($cake->image)
                    <img src="{{ asset('storage/' . $cake->image) }}" alt="{{ $cake->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">No Image</span>
                    </div>
                @endif
                
                <div class="p-4">
                    <h3 class="font-bold text-lg mb-2">{{ $cake->name }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($cake->description, 80) }}</p>
                    <p class="text-sm text-gray-500 mb-2">{{ $cake->category->name }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-pink-600">Rs. {{ number_format($cake->price, 2) }}</span>
                        <a href="{{ route('cakes.show', $cake->id) }}" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
                            View
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No cakes found matching your criteria.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $cakes->links() }}
    </div>
</div>