<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-b from-white to-rose-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-rose-100">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-stone-800">Forgot Password?</h2>
                    <p class="mt-2 text-gray-600">No worries! Enter your email and we'll send you an OTP to reset your password.</p>
                </div>

                @if (session('success'))
                    <div class="mb-6 bg-green-50 border-2 border-green-200 text-green-700 px-4 py-3 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-2 border-red-200 text-red-700 px-4 py-3 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.send-otp') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-bold text-stone-800 mb-2">
                            <i class="fas fa-envelope text-rose-500 mr-2"></i>Email Address
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            autofocus
                            class="w-full border-2 border-rose-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition"
                            placeholder="Enter your email"
                        >
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white font-bold py-3 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>Send OTP
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-rose-600 hover:text-rose-700 font-semibold text-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>