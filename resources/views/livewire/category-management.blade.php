<div>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-16 xl:px-24">

            <!-- Header -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Category Management</h2>
                    <p class="text-gray-600">Manage product categories</p>
                </div>
                <button wire:click="$set('showForm', true)" 
                        class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all gap-2">
                    <i class="fas fa-plus-circle"></i>
                    Add New Category
                </button>
            </div>

            <!-- Flash Messages -->
            @if(session()->has('message'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3"></i>
                        <span>{{ session('message') }}</span>
                    </div>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Categories Table -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-gray-100 px-6 py-4 border-b">
                    <h3 class="text-xl font-bold text-gray-900">All Categories</h3>
                    <p class="text-sm text-gray-600 mt-1">View and manage categories</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cakes Count</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $category->description ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">
                                            {{ $category->cakes_count }} cakes
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                        <button wire:click="editCategory({{ $category->id }})" 
                                                class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <button wire:click="deleteCategory({{ $category->id }})" 
                                                onclick="confirm('Delete this category?') || event.stopImmediatePropagation()"
                                                class="bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center text-gray-400">
                                        <i class="fas fa-tags text-6xl mb-4"></i>
                                        <p class="font-semibold">No categories yet</p>
                                        <p class="text-sm">Click "Add New Category" to create one</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Modal for Create/Edit --}}
            @if($showForm)
                <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-y-auto">
                        <div class="p-6 border-b flex justify-between items-center">
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $editingCategory ? 'Edit Category' : 'Add New Category' }}
                            </h3>
                            <button wire:click="resetForm" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>

                        <form wire:submit.prevent="{{ $editingCategory ? 'updateCategory' : 'createCategory' }}" class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Category Name *</label>
                                <input type="text" wire:model="name" 
                                       class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition" 
                                       placeholder="Enter category name" required>
                                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Description</label>
                                <textarea wire:model="description" rows="3"
                                          class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition"
                                          placeholder="Optional description..."></textarea>
                                @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end gap-3 mt-6">
                                <button type="button" wire:click="resetForm" 
                                        class="px-6 py-2 border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-6 py-2 bg-gray-900 hover:bg-gray-800 text-white font-medium rounded-lg transition-colors">
                                    {{ $editingCategory ? 'Update Category' : 'Create Category' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
