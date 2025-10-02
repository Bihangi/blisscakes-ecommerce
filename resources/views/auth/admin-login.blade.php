<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat" 
         style="background-image: url('/images/login-bg.jpg');">
        
        <div class="w-full min-h-screen flex items-center justify-center bg-black bg-opacity-10 px-4 sm:px-6 lg:px-8">
            <div class="relative bg-pink-50 shadow-2xl rounded-3xl p-8 sm:p-10 w-full max-w-md lg:max-w-lg xl:max-w-xl text-center">
                
                <!-- Back Arrow -->
                <a href="{{ route('welcome') }}" 
                   class="absolute top-4 left-4 sm:top-6 sm:left-6 text-3xl sm:text-4xl text-black font-bold hover:text-red-600 transition-colors">
                    ←
                </a>

                <!-- Title with Crown Icon -->
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-6 sm:mb-8 mt-2">
                    ADMIN LOGIN
                </h1>

                <!-- Display Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @session('error')
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                        {{ $value }}
                    </div>
                @endsession

                @session('success')
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                        {{ $value }}
                    </div>
                @endsession

                <!-- Login Form -->
                <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5 sm:space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div class="text-left">
                        <label class="block font-semibold text-gray-800 text-sm sm:text-base mb-2">Admin Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            required 
                            placeholder="Enter your admin email"
                            autofocus 
                            autocomplete="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 sm:py-3.5 text-sm sm:text-base bg-purple-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400 transition-all"
                        />
                    </div>

                    <!-- Password Field -->
                    <div class="text-left">
                        <label class="block font-semibold text-gray-800 text-sm sm:text-base mb-2">Admin Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            required 
                            placeholder="Enter your admin password"
                            autocomplete="current-password"
                            class="w-full px-4 py-3 sm:py-3.5 text-sm sm:text-base bg-purple-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400 transition-all"
                        />
                    </div>

                    <!-- Remember Me -->
                    <div class="text-left">
                        <label class="flex items-center cursor-pointer">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                name="remember"
                                class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                            />
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button 
                        type="submit"
                        class="w-full bg-white text-red-500 font-bold text-sm sm:text-base border-2 border-red-400 py-3 sm:py-3.5 rounded-lg hover:bg-red-50 hover:border-red-500 transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg"
                    >
                        LOGIN AS ADMIN
                    </button>
                </form>

                <!-- Customer Login Link -->
                <p class="mt-6 text-sm sm:text-base text-gray-700">
                    Not an admin? 
                    <a href="{{ route('login') }}" class="text-black font-bold underline hover:text-red-600 transition-colors">
                        Customer Login
                    </a>
                </p>

                <!-- Additional Info -->
                <div class="mt-6 pt-6 border-t border-gray-300">
                    <p class="text-xs sm:text-sm text-gray-600">
                        Restricted access for administrators only
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>