<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-4 bg-cover bg-center relative" 
         style="background-image: url('/images/login-bg.jpg');">
        
        <!-- Blurred background overlay -->
        <div class="absolute inset-0 backdrop-blur-sm bg-black/20"></div>

        <!-- Signup Card -->
        <div class="relative z-10 w-full max-w-md lg:max-w-lg xl:max-w-xl">
            <div class="bg-pink-50 shadow-lg rounded-3xl p-8 sm:p-10 lg:p-12">
                
                <!-- Back Arrow -->
                <a href="{{ route('welcome') }}" 
                   class="absolute top-4 left-4 text-3xl lg:text-4xl text-black font-bold hover:text-red-600 transition-colors">
                    🡐
                </a>
                
                <!-- Title -->
                <h1 class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-6 lg:mb-8">SIGNUP</h1>

                <!-- Display Error Messages -->
                <x-validation-errors class="mb-4" />

                <!-- Display Success Messages -->
                @session('success')
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ $value }}
                    </div>
                @endsession

                @session('error')
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ $value }}
                    </div>
                @endsession

                <!-- Signup Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- First Name Field -->
                    <div class="mb-4 text-left">
                        <label for="first_name" class="font-semibold text-sm lg:text-base block mb-2">First Name</label>
                        <input 
                            id="first_name"
                            type="text" 
                            name="first_name" 
                            required 
                            placeholder="Enter your first name"
                            autofocus
                            value="{{ old('first_name') }}"
                            class="w-full px-4 py-2 lg:py-3 text-base bg-purple-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-300"
                        />
                    </div>

                    <!-- Last Name Field -->
                    <div class="mb-4 text-left">
                        <label for="last_name" class="font-semibold text-sm lg:text-base block mb-2">Last Name</label>
                        <input 
                            id="last_name"
                            type="text" 
                            name="last_name" 
                            required 
                            placeholder="Enter your last name"
                            value="{{ old('last_name') }}"
                            class="w-full px-4 py-2 lg:py-3 text-base bg-purple-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-300"
                        />
                    </div>

                    <!-- Username Field -->
                    <div class="mb-4 text-left">
                        <label for="username" class="font-semibold text-sm lg:text-base block mb-2">Username</label>
                        <input 
                            id="username"
                            type="text" 
                            name="username" 
                            required 
                            placeholder="Choose a username"
                            value="{{ old('username') }}"
                            class="w-full px-4 py-2 lg:py-3 text-base bg-purple-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-300"
                        />
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4 text-left">
                        <label for="email" class="font-semibold text-sm lg:text-base block mb-2">Email</label>
                        <input 
                            id="email"
                            type="email" 
                            name="email" 
                            required 
                            placeholder="Enter your email"
                            autocomplete="username"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-2 lg:py-3 text-base bg-purple-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-300"
                        />
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4 text-left">
                        <label for="password" class="font-semibold text-sm lg:text-base block mb-2">Password</label>
                        <input 
                            id="password"
                            type="password" 
                            name="password" 
                            required 
                            placeholder="Enter your password"
                            autocomplete="new-password"
                            class="w-full px-4 py-2 lg:py-3 text-base bg-purple-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-300"
                        />
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-6 text-left">
                        <label for="password_confirmation" class="font-semibold text-sm lg:text-base block mb-2">Confirm Password</label>
                        <input 
                            id="password_confirmation"
                            type="password" 
                            name="password_confirmation" 
                            required 
                            placeholder="Confirm your password"
                            autocomplete="new-password"
                            class="w-full px-4 py-2 lg:py-3 text-base bg-purple-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-300"
                        />
                    </div>

                    <!-- Terms and Privacy Policy (if enabled) -->
                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mb-4 text-left">
                            <label for="terms" class="flex items-start cursor-pointer">
                                <input 
                                    id="terms" 
                                    type="checkbox" 
                                    name="terms"
                                    required
                                    class="w-4 h-4 mt-1 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                                />
                                <span class="ml-2 text-xs lg:text-sm text-gray-700">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-purple-600 hover:text-purple-800">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-purple-600 hover:text-purple-800">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </span>
                            </label>
                        </div>
                    @endif

                    <!-- Signup Button -->
                    <button 
                        type="submit"
                        class="w-full bg-white text-red-500 font-bold border-2 border-red-400 py-3 text-base rounded-lg hover:bg-red-400 hover:text-white transition-all duration-200 transform hover:scale-[1.02]"
                    >
                        SIGNUP
                    </button>
                </form>

                <!-- Login Link -->
                <p class="mt-4 text-sm lg:text-base text-center text-gray-700">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-black font-bold underline hover:text-gray-600 transition-colors">
                        click here
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>