<!-- CAKE MANAGEMENT -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-16 xl:px-24 py-10">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-2 flex items-center gap-3">
                        <i class="fas fa-birthday-cake text-rose-600"></i>
                        Cake Management
                    </h1>
                    <p class="text-slate-600">Manage your cake inventory and availability</p>
                </div>
                <button wire:click="createCake" class="bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    Add New Cake
                </button>
            </div>
        </div>

        @if(session()->has('message'))
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 rounded-xl mb-6 shadow-sm">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <span class="text-green-800 font-medium">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <!-- Cakes Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-slate-100">
            <div class="bg-gradient-to-r from-slate-50 to-gray-50 px-6 py-5 border-b-2 border-slate-200">
                <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                    <i class="fas fa-list text-rose-600"></i>
                    All Cakes
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y-2 divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @foreach($cakes as $cake)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($cake->image)
                                        <img src="{{ asset('storage/' . $cake->image) }}" alt="{{ $cake->name }}" 
                                             class="w-16 h-16 object-cover rounded-xl shadow-md border-2 border-slate-100">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-rose-100 to-pink-100 rounded-xl flex items-center justify-center">
                                            <i class="fas fa-birthday-cake text-rose-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-slate-900">{{ $cake->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-bold">
                                        {{ $cake->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-base font-bold text-slate-900">Rs. {{ number_format($cake->price, 2) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="toggleAvailability({{ $cake->id }})" 
                                            class="px-4 py-2 rounded-full text-sm font-bold shadow-sm transition-all
                                            {{ $cake->is_available ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border-2 border-green-200 hover:shadow-md' : 'bg-gradient-to-r from-red-100 to-rose-100 text-red-800 border-2 border-red-200 hover:shadow-md' }}">
                                        <i class="fas {{ $cake->is_available ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                        {{ $cake->is_available ? 'Available' : 'Unavailable' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <button wire:click="editCake({{ $cake->id }})" 
                                                class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg text-sm font-bold transition-all">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <button wire:click="deleteCake({{ $cake->id }})" 
                                                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg text-sm font-bold transition-all">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
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
</div>
