<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Cake Management</h1>
        <button wire:click="createCake" class="bg-pink-500 text-white px-6 py-3 rounded hover:bg-pink-600">
            Add New Cake
        </button>
    </div>

    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    {{-- Cakes Table --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Image</th>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Category</th>
                    <th class="px-6 py-3 text-left">Price</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cakes as $cake)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            @if($cake->image)
                                <img src="{{ asset('storage/' . $cake->image) }}" alt="{{ $cake->name }}" 
                                     class="w-16 h-16 object-cover rounded">
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $cake->name }}</td>
                        <td class="px-6 py-4">{{ $cake->category->name }}</td>
                        <td class="px-6 py-4">Rs. {{ number_format($cake->price, 2) }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="toggleAvailability({{ $cake->id }})" 
                                    class="px-3 py-1 rounded text-sm {{ $cake->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $cake->is_available ? 'Available' : 'Unavailable' }}
                            </button>
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="editCake({{ $cake->id }})" 
                                    class="text-blue-500 hover:text-blue-700 mr-3">Edit</button>
                            <button wire:click="deleteCake({{ $cake->id }})" 
                                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                    class="text-red-500 hover:text-red-700">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $cakes->links() }}
    </div>

    {{-- Modal for Create/Edit --}}
    @if($showCreateForm || $showEditForm)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 max-w-2xl w-full max-h-screen overflow-y-auto">
                <h2 class="text-2xl font-bold mb-4">{{ $showEditForm ? 'Edit Cake' : 'Add New Cake' }}</h2>
                
                <form wire:submit.prevent="{{ $showEditForm ? 'updateCake' : 'createCake' }}">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block mb-2">Name *</label>
                            <input type="text" wire:model="name" class="w-full border rounded px-4 py-2" required>
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block mb-2">Description *</label>
                            <textarea wire:model="description" class="w-full border rounded px-4 py-2" rows="3" required></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block mb-2">Price (Rs.) *</label>
                            <input type="number" step="0.01" wire:model="price" class="w-full border rounded px-4 py-2" required>
                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block mb-2">Category *</label>
                            <select wire:model="category_id" class="w-full border rounded px-4 py-2" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block mb-2">Flavor</label>
                            <input type="text" wire:model="flavor" class="w-full border rounded px-4 py-2">
                        </div>

                        <div>
                            <label class="block mb-2">Size</label>
                            <select wire:model="size" class="w-full border rounded px-4 py-2">
                                <option value="">Select Size</option>
                                <option value="Small">Small</option>
                                <option value="Medium">Medium</option>
                                <option value="Large">Large</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2">Occasion</label>
                            <input type="text" wire:model="occasion" class="w-full border rounded px-4 py-2">
                        </div>

                        <div class="col-span-2">
                            <label class="block mb-2">Ingredients</label>
                            <textarea wire:model="ingredients" class="w-full border rounded px-4 py-2" rows="2"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block mb-2">Image</label>
                            <input type="file" wire:model="image" class="w-full border rounded px-4 py-2">
                            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="is_available" class="mr-2">
                                Available for purchase
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" wire:click="$set('showModal', false)" 
                                class="px-6 py-2 border rounded hover:bg-gray-100">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2 bg-pink-500 text-white rounded hover:bg-pink-600">
                            {{ $showEditForm ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>