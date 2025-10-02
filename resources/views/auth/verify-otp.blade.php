<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-b from-white to-rose-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-rose-100">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-r from-rose-400 to-pink-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lock text-3xl text-white"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-stone-800">Verify OTP</h2>
                    <p class="mt-2 text-gray-600">Enter the 6-digit code sent to</p>
                    <p class="font-semibold text-rose-600">{{ session('reset_email') }}</p>
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

                <form method="POST" action="{{ route('password.verify-otp') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="otp" class="block text-sm font-bold text-stone-800 mb-2 text-center">
                            Enter OTP Code
                        </label>
                        <input 
                            id="otp" 
                            type="text" 
                            name="otp" 
                            required 
                            autofocus
                            maxlength="6"
                            pattern="[0-9]{6}"
                            class="w-full border-2 border-rose-200 rounded-xl px-4 py-4 text-center text-2xl font-bold tracking-widest focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition"
                            placeholder="000000"
                        >
                        <p class="text-xs text-gray-500 mt-2 text-center">Code expires in 1 minute</p>
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white font-bold py-3 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                        <i class="fas fa-check-circle mr-2"></i>Verify OTP
                    </button>
                </form>

                <div class="mt-6 text-center space-y-3">
                    <p class="text-sm text-gray-600">Didn't receive the code?</p>
                    <form method="POST" action="{{ route('password.resend-otp') }}">
                        @csrf
                        <button type="submit" class="text-rose-600 hover:text-rose-700 font-semibold text-sm">
                            <i class="fas fa-redo mr-1"></i> Resend OTP
                        </button>
                    </form>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-700 font-semibold text-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>