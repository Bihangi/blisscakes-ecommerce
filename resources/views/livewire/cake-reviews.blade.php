<div class="bg-gradient-to-b from-white to-rose-50 py-10 px-4 md:px-16">
    <div class="max-w-6xl mx-auto">
        
        <!-- Back Button -->
        <a href="{{ route('cakes.browse') }}" class="inline-flex items-center text-rose-600 hover:text-rose-700 font-semibold mb-6 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Products
        </a>

        <!-- Product Header with Rating Summary -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 border-2 border-rose-100">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Product Image -->
                <div class="md:w-1/3">
                    @if($cake->image)
                        <img src="{{ asset('storage/' . $cake->image) }}" 
                             alt="{{ $cake->name }}" 
                             class="w-full rounded-xl shadow-md">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-birthday-cake text-6xl text-gray-300"></i>
                        </div>
                    @endif
                </div>

                <!-- Product Info & Rating Summary -->
                <div class="md:w-2/3">
                    <h1 class="text-3xl md:text-4xl font-bold text-stone-800 mb-4">{{ $cake->name }}</h1>
                    
                    <!-- Rating Summary -->
                    <div class="bg-gradient-to-r from-rose-50 to-pink-50 rounded-xl p-6 mb-6">
                        <div class="flex items-center gap-6 flex-wrap">
                            <div class="text-center">
                                <div class="text-5xl font-bold text-rose-600 mb-2">
                                    {{ number_format($averageRating, 1) }}
                                </div>
                                <div class="flex gap-1 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-xl {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                                <p class="text-sm text-gray-600">{{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}</p>
                            </div>
                            
                            <div class="flex-1">
                                <button 
                                    wire:click="toggleReviewForm"
                                    class="w-full md:w-auto bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white font-semibold px-8 py-3 rounded-full shadow-md hover:shadow-lg transition-all transform hover:scale-105">
                                    <i class="fas fa-star mr-2"></i>
                                    Write a Review
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="space-y-3 text-gray-700">
                        <p><span class="font-semibold">Price:</span> Rs. {{ number_format($cake->price, 2) }}</p>
                        <p><span class="font-semibold">Size:</span> {{ $cake->size ?? 'Standard' }}</p>
                        @if($cake->category)
                            <p><span class="font-semibold">Category:</span> {{ $cake->category->name }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session()->has('success'))
            <div class="bg-green-100 border-2 border-green-400 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center">
                <i class="fas fa-check-circle text-2xl mr-3"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="bg-red-100 border-2 border-red-400 text-red-700 px-6 py-4 rounded-xl mb-6 flex items-center">
                <i class="fas fa-exclamation-circle text-2xl mr-3"></i>
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Review Form -->
        @if($showReviewForm)
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 border-2 border-rose-100">
                <h2 class="text-2xl font-bold text-stone-800 mb-6 flex items-center">
                    <i class="fas fa-pen-to-square text-rose-500 mr-3"></i>
                    Share Your Experience
                </h2>

                <form wire:submit.prevent="submitReview" class="space-y-6">
                    <!-- Name Field -->
                    <div>
                        <label class="block font-semibold text-stone-800 mb-3">Name to display</label>
                        <input 
                            type="text" 
                            wire:model="userName"
                            placeholder="e.g., John D., JD, etc."
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition"
                            {{ $postAnonymously ? 'disabled' : '' }}
                        >
                        <p class="text-sm text-gray-500 mt-2">
                            Leave as-is to use your profile name, or customize it. If you tick "Post anonymously", this will be ignored.
                        </p>
                        @error('userName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Anonymous Checkbox -->
                    <div>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                wire:model="postAnonymously"
                                class="w-5 h-5 accent-rose-500 rounded focus:ring-2 focus:ring-rose-400"
                            >
                            <span class="font-medium text-gray-700">Post anonymously</span>
                        </label>
                    </div>

                    <!-- Rating -->
                    <div>
                        <label class="block font-semibold text-stone-800 mb-3">Rating</label>
                        <div class="flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button 
                                    type="button"
                                    wire:click="setRating({{ $i }})"
                                    class="text-4xl transition-all transform hover:scale-110">
                                    <i class="fas fa-star {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                </button>
                            @endfor
                        </div>
                        @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Review Comment -->
                    <div>
                        <label class="block font-semibold text-stone-800 mb-3">Your Review</label>
                        <textarea 
                            wire:model="comment"
                            rows="5"
                            placeholder="Share your experience with this cake..."
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition resize-none"
                        ></textarea>
                        <p class="text-sm text-gray-500 mt-2">Minimum 10 characters</p>
                        @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex gap-4">
                        <button 
                            type="submit"
                            class="flex-1 bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white font-bold px-8 py-3 rounded-full shadow-md hover:shadow-lg transition-all transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Review
                        </button>
                        <button 
                            type="button"
                            wire:click="toggleReviewForm"
                            class="px-8 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-full hover:bg-gray-50 transition">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Reviews Section -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-rose-100">
            <h2 class="text-2xl font-bold text-stone-800 mb-6 flex items-center">
                <i class="fas fa-comments text-rose-500 mr-3"></i>
                Client Reviews
            </h2>

            @forelse($reviews as $review)
                <div class="border-b border-gray-200 py-6 last:border-b-0">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-bold text-stone-800 text-lg">{{ $review->user_name }}</h3>
                            <p class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-lg {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                    
                    @if($review->is_verified_purchase)
                        <span class="inline-block mt-3 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fas fa-check-circle mr-1"></i>
                            Verified Purchase
                        </span>
                    @endif
                </div>
            @empty
                <div class="text-center py-12">
                    <i class="fas fa-star text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg font-medium mb-4">No reviews yet</p>
                    <p class="text-gray-400">Be the first to review this product!</p>
                    <button 
                        wire:click="toggleReviewForm"
                        class="mt-6 bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white font-semibold px-8 py-3 rounded-full shadow-md hover:shadow-lg transition-all transform hover:scale-105">
                        Write First Review
                    </button>
                </div>
            @endforelse
        </div>
    </div>
</div>