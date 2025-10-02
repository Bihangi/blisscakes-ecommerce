<div>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-16 xl:px-24">
            
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Cake Management</h2>
                        <p class="text-gray-600">Manage your cake inventory and availability</p>
                    </div>
                    <button wire:click="$set('showCreateForm', true)" class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all gap-2">
                        <i class="fas fa-plus-circle"></i>
                        Add New Cake
                    </button>
                </div>
            </div>

            <!-- Success Message -->
            @if(session()->has('message'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3"></i>
                        <span>{{ session('message') }}</span>
                    </div>
                </div>
            @endif

            <!-- Cakes Table -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-gray-100 px-6 py-4 border-b">
                    <h3 class="text-xl font-bold text-gray-900">All Cakes</h3>
                    <p class="text-sm text-gray-600 mt-1">View and manage all cake products</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Image</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($cakes as $cake)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($cake->image)
                                            <img src="{{ asset('storage/' . $cake->image) }}" alt="{{ $cake->name }}" 
                                                 class="w-16 h-16 object-cover rounded-lg shadow-sm">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-birthday-cake text-2xl text-gray-300"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-semibold text-gray-900">{{ $cake->name }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">
                                            {{ $cake->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-semibold text-gray-900">Rs. {{ number_format($cake->price, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button wire:click="toggleAvailability({{ $cake->id }})" 
                                                class="px-4 py-1.5 rounded-full text-xs font-semibold transition-colors
                                                {{ $cake->is_available ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                            <i class="fas {{ $cake->is_available ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                            {{ $cake->is_available ? 'Available' : 'Unavailable' }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex gap-2">
                                            <button wire:click="editCake({{ $cake->id }})" 
                                                    class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </button>
                                            <button wire:click="deleteCake({{ $cake->id }})" 
                                                    onclick="confirm('Are you sure you want to delete this cake?') || event.stopImmediatePropagation()"
                                                    class="bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="text-gray-400">
                                            <i class="fas fa-birthday-cake text-6xl mb-4"></i>
                                            <p class="text-base font-semibold">No cakes found</p>
                                            <p class="text-sm mt-1">Click "Add New Cake" to create your first cake product</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $cakes->links() }}
            </div>

            {{-- Modal for Create/Edit --}}
            @if($showCreateForm || $showEditForm)
                <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                        <div class="p-6 border-b">
                            <h3 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas {{ $showEditForm ? 'fa-edit' : 'fa-plus-circle' }}"></i>
                                {{ $showEditForm ? 'Edit Cake' : 'Add New Cake' }}
                            </h3>
                        </div>
                        
                        <form wire:submit.prevent="{{ $showEditForm ? 'updateCake' : 'createCake' }}" class="p-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="col-span-2">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Cake Name *
                                    </label>
                                    <input type="text" wire:model="name" 
                                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition" 
                                           placeholder="Enter cake name" required>
                                    @error('name') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Description *
                                    </label>
                                    <textarea wire:model="description" 
                                              class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition" 
                                              rows="3" placeholder="Describe the cake..." required></textarea>
                                    @error('description') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Price (Rs.) *
                                    </label>
                                    <input type="number" step="0.01" wire:model="price" 
                                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition" 
                                           placeholder="0.00" required>
                                    @error('price') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Category *
                                    </label>
                                    <select wire:model="category_id" 
                                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Flavor
                                    </label>
                                    <input type="text" wire:model="flavor" 
                                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition" 
                                           placeholder="e.g., Chocolate, Vanilla">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Size
                                    </label>
                                    <select wire:model="size" 
                                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition">
                                        <option value="">Select Size</option>
                                        <option value="Small">Small</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Large">Large</option>
                                    </select>
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Occasion
                                    </label>
                                    <input type="text" wire:model="occasion" 
                                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition" 
                                           placeholder="e.g., Birthday, Wedding, Anniversary">
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Ingredients
                                    </label>
                                    <textarea wire:model="ingredients" 
                                              class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition" 
                                              rows="2" placeholder="List main ingredients..."></textarea>
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Cake Image
                                    </label>
                                    <input type="file" wire:model="image" 
                                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                                    @error('image') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-2">
                                    <label class="flex items-center cursor-pointer bg-gray-50 p-4 rounded-lg border-2 border-gray-200 hover:border-gray-300 transition">
                                        <input type="checkbox" wire:model="is_available" class="w-5 h-5 text-gray-900 rounded focus:ring-gray-400 mr-3">
                                        <div>
                                            <span class="text-sm font-semibold text-gray-900">Available for Purchase</span>
                                            <p class="text-xs text-gray-600">Customers can order this cake</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                                <button type="button" wire:click="hideCreateForm" 
                                        class="px-6 py-2 border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                                    <i class="fas fa-times mr-1"></i>
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-6 py-2 bg-gray-900 hover:bg-gray-800 text-white font-medium rounded-lg transition-colors">
                                    <i class="fas {{ $showEditForm ? 'fa-save' : 'fa-plus' }} mr-1"></i>
                                    {{ $showEditForm ? 'Update Cake' : 'Create Cake' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>