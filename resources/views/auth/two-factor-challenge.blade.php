<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat" 
         style="background-image: url('/images/login-bg.jpg');">
        
        <div class="w-full min-h-screen flex items-center justify-center bg-black bg-opacity-10 px-4 sm:px-6 lg:px-8">
            <div class="relative bg-pink-50 shadow-2xl rounded-3xl p-8 sm:p-10 w-full max-w-md lg:max-w-lg xl:max-w-xl text-center">
                
                <!-- Back to Login -->
                <a href="{{ route('login') }}" 
                   class="absolute top-4 left-4 sm:top-6 sm:left-6 text-3xl sm:text-4xl text-black font-bold hover:text-red-600 transition-colors">
                    ←
                </a>

                <!-- Icon -->
                <div class="w-20 h-20 bg-gradient-to-r from-pink-400 to-red-400 rounded-full flex items-center justify-center mx-auto mb-4 mt-2">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>

                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Two-Factor Authentication</h1>
                <p class="text-sm text-gray-600 mb-2">Enter the 6-digit code sent to</p>
                <p class="font-semibold text-red-500 mb-6">{{ $user->email }}</p>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('two-factor.verify') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block font-semibold text-gray-800 text-sm mb-2">Verification Code</label>
                        <input 
                            id="two_factor_code" 
                            type="text" 
                            name="two_factor_code" 
                            required 
                            autofocus
                            maxlength="6"
                            pattern="[0-9]{6}"
                            class="w-full px-4 py-4 text-center text-2xl font-bold tracking-widest bg-purple-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400 transition-all"
                            placeholder="000000"
                        >
                        <p class="text-xs text-gray-500 mt-2">Code expires in 1 minute</p>
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-white text-red-500 font-bold text-sm sm:text-base border-2 border-red-400 py-3 sm:py-3.5 rounded-lg hover:bg-red-50 hover:border-red-500 transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg">
                        Verify Code
                    </button>
                </form>

                <div class="mt-6 space-y-3">
                    <p class="text-sm text-gray-600">Didn't receive the code?</p>
                    <form method="POST" action="{{ route('two-factor.resend') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-600 font-semibold text-sm underline">
                            Resend Code
                        </button>
                    </form>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-300">
                    <p class="text-xs text-gray-600">
                        Having trouble? 
                        <a href="{{ route('login') }}" class="text-red-500 hover:text-red-600 font-semibold underline">
                            Try logging in again
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>