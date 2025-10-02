<header style="background-color: rgb(235, 168, 168);" class="shadow-lg sticky top-0 z-50">
  <div class="container mx-auto px-6 py-4">
    <div class="flex items-center justify-between gap-6">
      
      <!-- Logo -->
      <a href="{{ route('home') }}" class="shrink-0">
        <img src="{{ asset('images/logo.png') }}" alt="BlissCakes Logo" 
             class="w-16 h-16 lg:w-18 lg:h-18 object-contain transition-transform hover:scale-110 drop-shadow-md">
      </a>

      <!-- Search Bar (Desktop & Tablet) -->
      <form action="{{ route('cakes.browse') }}" method="GET" 
            class="hidden md:flex flex-grow max-w-sm lg:max-w-md mx-4">
        <div class="relative w-full">
          <input
            type="text"
            name="search"
            placeholder="Search cakes..."
            class="w-full px-4 py-2 pr-10 rounded-full border border-white/30 
                   focus:outline-none focus:ring-2 focus:ring-white focus:border-white 
                   text-base text-gray-800 placeholder-gray-500 transition-all"
            style="background-color: rgba(255, 255, 255, 0.9)"
            autocomplete="off"
          >
          <button type="submit" 
                  class="absolute right-3 top-1/2 transform -translate-y-1/2 
                         text-gray-600 hover:text-pink-700 transition-colors">
            <i class="fas fa-search text-sm"></i>
          </button>
        </div>
      </form>

      <!-- Desktop Navigation -->
      <nav class="hidden lg:flex items-center gap-6 text-gray-900 font-bold text-xl">
        <a href="{{ route('home') }}" class="hover:text-white transition-colors px-2 py-1">
          Home
        </a>

        <a href="{{ route('about') }}" class="hover:text-white transition-colors px-2 py-1">
          About
        </a>

        <!-- Cakes Dropdown -->
        <div class="relative group">
          <button class="hover:text-white transition-colors flex items-center gap-1 px-2 py-1">
            Cakes
            <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div class="absolute left-0 mt-2 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 shadow-xl rounded-lg overflow-hidden" style="background-color: rgb(235, 168, 168);">
            <div class="py-2">
              <a href="{{ route('cakes.browse') }}" class="block px-5 py-3 text-gray-900 hover:bg-white/30 hover:text-white transition-colors text-lg font-semibold">
                All Cakes
              </a>
              <a href="{{ route('cakes.browse', ['categoryFilter' => 1]) }}" class="block px-5 py-3 text-gray-900 hover:bg-white/30 hover:text-white transition-colors text-lg font-semibold">
                Birthday Cakes
              </a>
              <a href="{{ route('cakes.browse', ['categoryFilter' => 2]) }}" class="block px-5 py-3 text-gray-900 hover:bg-white/30 hover:text-white transition-colors text-lg font-semibold">
                Wedding Cakes
              </a>
              <a href="{{ route('cakes.browse', ['categoryFilter' => 3]) }}" class="block px-5 py-3 text-gray-900 hover:bg-white/30 hover:text-white transition-colors text-lg font-semibold">
                Custom Cakes
              </a>
            </div>
          </div>
        </div>
      </nav>

      <!-- Right Icons -->
      <div class="flex items-center gap-5">
        @auth
          <!-- Cart -->
          <a href="{{ route('cart') }}" class="relative group">
            <div class="text-gray-900 hover:text-white transition-colors">
              <i class="fas fa-shopping-cart text-2xl lg:text-2xl drop-shadow"></i>
              @if(auth()->user()->cart && auth()->user()->cart->cartItems->count() > 0)
                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center shadow-lg animate-pulse">
                  {{ auth()->user()->cart->cartItems->sum('quantity') }}
                </span>
              @endif
            </div>
          </a>
          
          <!-- User Menu -->
          <div class="relative group">
            <button class="flex items-center gap-2 text-gray-900 hover:text-white transition-colors">
              <i class="fas fa-user text-2xl lg:text-2xl drop-shadow"></i>
              <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-300 hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="absolute right-0 mt-3 w-64 bg-white rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden">
              <div class="py-2">
                <div class="px-5 py-4 bg-gradient-to-br from-pink-50 to-rose-50 border-b border-gray-200">
                  <p class="text-base font-bold text-gray-900 truncate">{{ auth()->user()->username }}</p>
                  <p class="text-sm text-gray-600 truncate">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-5 py-3 text-gray-700 hover:bg-pink-50 transition-colors text-base font-medium">
                  <i class="fas fa-box text-lg w-5"></i>My Orders
                </a>
                @if(auth()->user()->isAdmin())
                  <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-5 py-3 text-gray-700 hover:bg-pink-50 transition-colors text-base font-medium">
                    <i class="fas fa-shield-alt text-lg w-5"></i>Admin Panel
                  </a>
                @endif
                <div class="border-t border-gray-200 mt-2">
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-red-600 hover:bg-red-50 transition-colors text-base font-medium">
                      <i class="fas fa-sign-out-alt text-lg w-5"></i>Logout
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @else
          <a href="{{ route('login') }}" class="flex items-center gap-2 bg-white text-gray-900 px-5 py-2.5 rounded-full font-bold text-base hover:bg-gray-100 transition-all transform hover:scale-105 shadow-md">
            <i class="fas fa-user"></i>
            <span class="hidden sm:inline">Login</span>
          </a>
        @endauth

        <!-- Mobile Menu Toggle -->
        <button class="lg:hidden text-gray-900 hover:text-white transition-colors" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
          <i class="fas fa-bars text-2xl drop-shadow"></i>
        </button>
      </div>
    </div>

    <!-- Mobile Search -->
    <form action="{{ route('cakes.browse') }}" method="GET" class="md:hidden mt-3 px-2">
      <div class="relative">
        <input
          type="text"
          name="search"
          placeholder="Search..."
          class="w-full px-3 py-2 pr-9 rounded-full border border-gray-300 
                 focus:outline-none focus:ring-2 focus:ring-pink-400
                 text-sm text-gray-800 placeholder-gray-500"
          style="background-color: rgba(255, 255, 255, 0.95)"
          autocomplete="off"
        >
        <button type="submit" 
                class="absolute right-3 top-1/2 transform -translate-y-1/2 
                       text-gray-600 hover:text-pink-700">
          <i class="fas fa-search text-sm"></i>
        </button>
      </div>
    </form>
  </div>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="hidden lg:hidden bg-white border-t-2 shadow-lg">
    <nav class="container mx-auto px-6 py-4 flex flex-col gap-1">
      <a href="{{ route('home') }}" class="px-4 py-3 text-gray-900 hover:bg-pink-100 hover:text-pink-700 rounded-lg transition-colors text-base font-medium">
        Home
      </a>
      <a href="{{ route('about') }}" class="px-4 py-3 text-gray-900 hover:bg-pink-100 hover:text-pink-700 rounded-lg transition-colors text-base font-medium">
        About
      </a>
      <a href="{{ route('cakes.browse') }}" class="px-4 py-3 text-gray-900 hover:bg-pink-100 hover:text-pink-700 rounded-lg transition-colors text-base font-medium">
        All Cakes
      </a>
      <div class="border-t border-gray-200 my-2"></div>
      <a href="{{ route('cakes.browse', ['categoryFilter' => 1]) }}" class="px-4 py-3 text-gray-800 hover:bg-pink-100 hover:text-pink-700 rounded-lg transition-colors pl-8 text-base">
        Birthday Cakes
      </a>
      <a href="{{ route('cakes.browse', ['categoryFilter' => 2]) }}" class="px-4 py-3 text-gray-800 hover:bg-pink-100 hover:text-pink-700 rounded-lg transition-colors pl-8 text-base">
        Wedding Cakes
      </a>
      <a href="{{ route('cakes.browse', ['categoryFilter' => 3]) }}" class="px-4 py-3 text-gray-800 hover:bg-pink-100 hover:text-pink-700 rounded-lg transition-colors pl-8 text-base">
        Custom Cakes
      </a>
    </nav>
  </div>
</header>
