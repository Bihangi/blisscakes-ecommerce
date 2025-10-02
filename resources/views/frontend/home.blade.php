@extends('layouts.frontend')

@section('title', 'BlissCakes - Home')

@section('content')

<!-- Banner Section -->
<div class="relative w-full h-[450px] md:h-[500px] overflow-hidden">
  <img 
    src="{{ asset('images/home_page_prototype2.png') }}" 
    alt="Bliss Cakes Banner" 
    class="w-full h-full object-cover object-top"
  >

  <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent flex items-center">
    <div class="w-full px-6 md:px-12 lg:px-24">
      <div class="max-w-xl">
        <h1 class="text-3xl sm:text-4xl md:text-6xl font-bold text-white leading-tight mb-4">
          Crafted with Love,<br>Baked to Perfection
        </h1>
        <p class="text-lg md:text-xl text-white/90 mb-8">
          Discover our collection of handcrafted cakes for every celebration
        </p>
        <div class="flex flex-wrap gap-4">
          <a 
            href="{{ route('cakes.browse') }}" 
            class="bg-white text-gray-900 px-8 py-3 text-lg font-semibold rounded-full hover:bg-gray-100 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
          >
            Shop Now
          </a>
          <a 
            href="{{ route('about') }}" 
            class="bg-transparent border-2 border-white text-white px-8 py-3 text-lg font-semibold rounded-full hover:bg-white hover:text-gray-900 transition duration-300"
          >
            Learn More
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Best Sellers Section -->
<section class="px-8 md:px-24 pt-16 pb-12">
  <div class="flex items-center justify-between mb-10">
    <h2 class="text-2xl md:text-3xl text-black font-bold">Best Seller</h2>
    <a href="{{ route('cakes.browse') }}" class="text-black text-3xl hover:text-pink-500 transition">➜</a>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8" id="bestSellers">
    <!-- Will be loaded via JavaScript/Livewire -->
    <div class="col-span-full text-center py-8">
      <p class="text-gray-500">Loading cakes...</p>
    </div>
  </div>
</section>

<!-- Why Choose BlissCakes Section -->
<section class="px-8 md:px-24 py-16 bg-gray-100">
  <div class="text-center mb-12">
    <h2 class="text-3xl font-bold mb-4">Why Choose BlissCakes?</h2>
    <p class="text-gray-600">Experience the difference with our premium cake collection</p>
  </div>
  
  <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
      <div class="text-5xl mb-4">🍰</div>
      <h3 class="font-bold text-lg mb-2">Fresh Daily</h3>
      <p class="text-gray-600">All our cakes are baked fresh daily using premium ingredients</p>
    </div>
    <div class="bg-white p-8 rounded-lg shadow-md text-center">
      <div class="text-5xl mb-4">🚚</div>
      <h3 class="font-bold text-lg mb-2">Fast Delivery</h3>
      <p class="text-gray-600">Quick and safe delivery to your doorstep within Colombo</p>
    </div>
    <div class="bg-white p-8 rounded-lg shadow-md text-center">
      <div class="text-5xl mb-4">💝</div>
      <h3 class="font-bold text-lg mb-2">Custom Orders</h3>
      <p class="text-gray-600">Special occasion cakes customized just for you</p>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
// Load best sellers using API
document.addEventListener('DOMContentLoaded', function() {
    axios.get('/api/cakes?per_page=4')
        .then(response => {
            const container = document.getElementById('bestSellers');
            container.innerHTML = '';
            
            response.data.data.forEach(cake => {
                const card = `
                    <div class="bg-pink-100 rounded-xl shadow-md hover:shadow-xl transition p-6 text-center">
                        <div class="w-full h-48 flex items-center justify-center overflow-hidden rounded-lg mb-4">
                            ${cake.image ? 
                                `<img src="/storage/${cake.image}" alt="${cake.name}" class="h-full object-cover">` :
                                '<div class="text-gray-400">No Image</div>'
                            }
                        </div>
                        <h3 class="text-lg font-bold text-black">${cake.name}</h3>
                        <p class="text-sm text-gray-600 mt-1">${cake.size || 'Standard'}</p>
                        <p class="text-lg font-semibold text-gray-800 mt-2">Rs. ${parseFloat(cake.price).toLocaleString()}</p>
                        <a href="/cakes" class="inline-block mt-4 bg-pink-300 text-black font-semibold px-4 py-2 rounded-full hover:bg-pink-200 transition w-full">
                            View Product
                        </a>
                    </div>
                `;
                container.innerHTML += card;
            });
        })
        .catch(error => {
            console.error('Error loading cakes:', error);
            document.getElementById('bestSellers').innerHTML = '<p class="text-center text-red-500">Failed to load cakes</p>';
        });
});
</script>
@endpush