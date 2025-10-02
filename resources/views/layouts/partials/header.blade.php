<header style="background-color: rgb(214, 129, 129);" class="shadow-lg sticky top-0 z-50">
  <div class="container mx-auto px-4 py-3">
    <div class="flex items-center justify-between gap-3">
      
      <!-- Logo -->
      <a href="{{ route('home') }}" class="shrink-0">
        <img src="{{ asset('images/logo.png') }}" alt="BlissCakes Logo" 
             class="w-14 h-14 sm:w-16 sm:h-16 object-contain transition-transform hover:scale-110">
      </a>

      <!-- Search Bar (Desktop) -->
      <form action="{{ route('cakes.browse') }}" method="GET" 
            class="hidden md:flex flex-grow max-w-md">
        <div class="relative w-full">
          <input
            type="text"
            name="search"
            placeholder="Search for cakes..."
            class="w-full px-4 py-2.5 pr-10 rounded-full border-2 border-white/40 
                   focus:outline-none focus:ring-2 focus:ring-white 
                   text-base text-gray-800 placeholder-gray-600"
            style="background-color: rgba(255, 255, 255, 0.9)"
            autocomplete="off"
          >
          <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-pink-700">
            <i class="fas fa-search text-lg"></i>
          </button>
        </div>
      </form>

      <!-- Desktop Navigation -->
      <nav class="hidden lg:flex items-center gap-6 text-gray-900 font-bold text-lg">
        <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
        <a href="{{ route('about') }}" class="hover:text-white transition-colors">About</a>

        <!-- Cakes Dropdown -->
        <div class="relative group">
          <button class="hover:text-white transition-colors flex items-center gap-1">
            Cakes
            <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div class="absolute left-0 mt-2 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all shadow-xl rounded-lg overflow-hidden" style="background-color: rgb(235, 168, 168);">
            <a href="{{ route('cakes.browse') }}" class="block px-5 py-3 text-gray-900 hover:bg-white/30 hover:text-white transition-colors font-semibold">All Cakes</a>
            <a href="{{ route('cakes.browse', ['categoryFilter' => 1]) }}" class="block px-5 py-3 text-gray-900 hover:bg-white/30 hover:text-white transition-colors font-semibold">Birthday Cakes</a>
            <a href="{{ route('cakes.browse', ['categoryFilter' => 2]) }}" class="block px-5 py-3 text-gray-900 hover:bg-white/30 hover:text-white transition-colors font-semibold">Wedding Cakes</a>
            <a href="{{ route('cakes.browse', ['categoryFilter' => 3]) }}" class="block px-5 py-3 text-gray-900 hover:bg-white/30 hover:text-white transition-colors font-semibold">Anniversary Cakes</a>
          </div>
        </div>
      </nav>

      <!-- Right Icons -->
      <div class="flex items-center gap-4">
        @auth
          <a href="{{ route('cart') }}" class="relative">
            <i class="fas fa-shopping-cart text-2xl text-gray-900 hover:text-white transition-colors"></i>
            @if(auth()->user()->cart && auth()->user()->cart->cartItems->count() > 0)
              <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                {{ auth()->user()->cart->cartItems->sum('quantity') }}
              </span>
            @endif
          </a>
          
          <div class="hidden md:block relative group">
            <button class="flex items-center gap-2 text-gray-900 hover:text-white transition-colors">
              <i class="fas fa-user text-2xl"></i>
              <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
              <div class="px-5 py-4 bg-gradient-to-br from-pink-50 to-rose-50 border-b">
                <p class="font-bold text-gray-900">{{ auth()->user()->name }}</p>
                <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
              </div>
              <a href="{{ route('orders') }}" class="flex items-center gap-3 px-5 py-3 text-gray-700 hover:bg-pink-50 transition-colors">
                <i class="fas fa-box w-5"></i>My Orders
              </a>
              @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-5 py-3 text-gray-700 hover:bg-pink-50 transition-colors">
                  <i class="fas fa-shield-alt w-5"></i>Admin Panel
                </a>
              @endif
              <form method="POST" action="{{ route('logout') }}" class="border-t">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-red-600 hover:bg-red-50 transition-colors">
                  <i class="fas fa-sign-out-alt w-5"></i>Logout
                </button>
              </form>
            </div>
          </div>
        @else
          <a href="{{ route('login') }}" class="hidden md:flex items-center gap-2 bg-white text-gray-900 px-5 py-2.5 rounded-full font-bold hover:bg-gray-100 transition-all shadow-md">
            <i class="fas fa-user"></i>Login
          </a>
        @endauth

        <!-- Mobile Menu Button -->
        <button class="lg:hidden text-gray-900 hover:text-white p-2" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
          <i class="fas fa-bars text-2xl"></i>
        </button>
      </div>
    </div>

    <!-- Mobile Search -->
    <form action="{{ route('cakes.browse') }}" method="GET" class="md:hidden mt-3">
      <div class="relative">
        <input
          type="text"
          name="search"
          placeholder="Search cakes..."
          class="w-full px-4 py-2.5 pr-10 rounded-full border-2 border-white/40 focus:outline-none focus:ring-2 focus:ring-white text-base"
          style="background-color: rgba(255, 255, 255, 0.9)"
          autocomplete="off"
        >
        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </form>
  </div>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="hidden lg:hidden bg-white border-t-2 shadow-lg">
    <nav class="container mx-auto px-4 py-3 space-y-1" style="background-color: rgb(235, 168, 168);">
      <a href="{{ route('home') }}" class="block px-4 py-3 text-gray-900 hover:bg-white/30 rounded-lg transition-colors text-base font-medium">
        <i class="fas fa-home mr-2"></i>Home
      </a>
      <a href="{{ route('about') }}" class="block px-4 py-3 text-gray-900 hover:bg-white/30 rounded-lg transition-colors text-base font-medium">
        <i class="fas fa-info-circle mr-2"></i>About
      </a>
      <a href="{{ route('cakes.browse') }}" class="block px-4 py-3 text-gray-900 hover:bg-white/30 rounded-lg transition-colors text-base font-medium">
        <i class="fas fa-birthday-cake mr-2"></i>All Cakes
      </a>
      
      <div class="border-t-2 border-white/30 my-2"></div>
      <p class="px-4 py-2 text-sm font-bold text-gray-700">Categories</p>
      
      <a href="{{ route('cakes.browse', ['categoryFilter' => 1]) }}" class="block px-4 py-3 pl-8 text-gray-800 hover:bg-white/30 rounded-lg transition-colors">
        Birthday Cakes
      </a>
      <a href="{{ route('cakes.browse', ['categoryFilter' => 2]) }}" class="block px-4 py-3 pl-8 text-gray-800 hover:bg-white/30 rounded-lg transition-colors">
        Wedding Cakes
      </a>
      <a href="{{ route('cakes.browse', ['categoryFilter' => 3]) }}" class="block px-4 py-3 pl-8 text-gray-800 hover:bg-white/30 rounded-lg transition-colors">
        Anniversary Cakes
      </a>

      @auth
        <div class="border-t-2 border-white/30 my-2"></div>
        <a href="{{ route('orders') }}" class="block px-4 py-3 text-gray-900 hover:bg-white/30 rounded-lg transition-colors text-base font-medium">
          <i class="fas fa-user mr-2"></i>My Account
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full text-left px-4 py-3 text-red-700 hover:bg-red-50 rounded-lg transition-colors text-base font-medium">
            <i class="fas fa-sign-out-alt mr-2"></i>Logout
          </button>
        </form>
      @else
        <div class="border-t-2 border-white/30 my-2"></div>
        <a href="{{ route('login') }}" class="block px-4 py-3 bg-white text-gray-900 hover:bg-gray-100 rounded-lg transition-colors text-center text-base font-bold">
          <i class="fas fa-user mr-2"></i>Login
        </a>
      @endauth
    </nav>
  </div>
</header>