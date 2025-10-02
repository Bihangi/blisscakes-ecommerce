<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-white to-rose-50 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-4xl bg-white shadow-xl rounded-2xl border-2 border-rose-100 overflow-hidden">
        
        <!-- Header with back button -->
        <div class="bg-gradient-to-r from-pink-50 to-rose-50 border-b-2 border-rose-200 px-6 sm:px-10 py-6 flex items-center">
            <a href="{{ url('/') }}" class="mr-4 text-rose-600 hover:text-rose-800 transition">
                <!-- back arrow -->
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h3 class="text-2xl font-bold text-stone-800">Two-Factor Authentication</h3>
        </div>

        <!-- Body -->
        <div class="p-6 sm:p-10">

            @if (session('success'))
                <div class="mb-6 bg-green-100 border-2 border-green-400 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border-2 border-red-400 text-red-700 px-4 py-3 rounded-xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Info Box -->
            <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6 mb-8">
                <div class="flex items-start gap-4">
                    <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h4 class="font-bold text-stone-800 mb-2">What is Two-Factor Authentication?</h4>
                        <p class="text-gray-700 text-sm leading-relaxed">
                            2FA adds an extra layer of security to your account. When enabled, you'll need to enter a code sent to your email each time you log in, in addition to your password. This helps protect your account even if someone knows your password.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Status & Toggle -->
            <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-6 flex items-center justify-between">
                <div>
                    <p class="font-bold text-lg text-stone-800 mb-1">Two-Factor Authentication Status</p>
                    <p class="text-sm text-gray-600">
                        @if(Auth::user()->two_factor_enabled)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Enabled
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                Disabled
                            </span>
                        @endif
                    </p>
                </div>

                @if(Auth::user()->two_factor_enabled)
                    <form method="POST" action="{{ route('two-factor.disable') }}" class="flex gap-3 items-center">
                        @csrf
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Enter password to disable"
                            required
                            class="border-2 border-rose-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-rose-400 focus:outline-none text-sm"
                        >
                        <button 
                            type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-lg transition">
                            Disable
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('two-factor.enable') }}">
                        @csrf
                        <button 
                            type="submit"
                            class="bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-bold px-8 py-3 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            Enable 2FA
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
