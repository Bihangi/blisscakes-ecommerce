<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-b from-white to-rose-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-rose-100">
                <!-- Header -->
                <div class="text-center mb-8">
                    
                    <h2 class="text-3xl font-bold text-stone-800">Set New Password</h2>
                    <p class="mt-2 text-gray-600">Choose a strong password for your account</p>
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
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="password" class="block text-sm font-bold text-stone-800 mb-2">
                            <i class="fas fa-lock text-rose-500 mr-2"></i>New Password
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required
                            minlength="8"
                            class="w-full border-2 border-rose-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition"
                            placeholder="Enter new password"
                        >
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-stone-800 mb-2">
                            <i class="fas fa-lock text-rose-500 mr-2"></i>Confirm Password
                        </label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required
                            minlength="8"
                            class="w-full border-2 border-rose-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-400 focus:border-rose-400 transition"
                            placeholder="Re-enter new password"
                        >
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-bold py-3 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                        <i class="fas fa-check-circle mr-2"></i>Reset Password
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-700 font-semibold text-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>