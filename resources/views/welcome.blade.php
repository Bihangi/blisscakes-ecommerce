<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bliss Cake') }} - Freshly Baked Happiness</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&family=playfair-display:700,800,900" rel="stylesheet" />

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: 'Instrument Sans', sans-serif; }
        </style>
    @endif
</head>
<body class="antialiased">

    <!-- Main Wrapper -->
    <div class="min-h-screen relative overflow-hidden bg-gradient-to-br from-pink-50 via-pink-100 to-rose-100">
        
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-rose-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

        <!-- Navigation Bar -->
        <nav class="relative z-50 bg-white/80 backdrop-blur-md shadow-sm border-b border-pink-100">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20 lg:h-24">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Bliss Cake" class="h-12 lg:h-16 w-auto drop-shadow-md">
                        <span class="text-2xl lg:text-3xl font-bold text-gray-900 hidden sm:block">Bliss Cake</span>
                    </div>

                    <!-- Navigation Links -->
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" 
                                   class="inline-flex items-center justify-center bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold px-6 sm:px-8 py-2.5 sm:py-3 rounded-full shadow-lg hover:shadow-xl hover:from-red-600 hover:to-red-700 transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="inline-flex items-center justify-center border-2 border-red-500 bg-transparent text-red-600 font-semibold px-5 sm:px-7 py-2 sm:py-2.5 rounded-full hover:bg-red-50 transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base">
                                    Login
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                       class="inline-flex items-center justify-center bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold px-5 sm:px-7 py-2 sm:py-2.5 rounded-full shadow-lg hover:shadow-xl hover:from-red-600 hover:to-red-700 transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base">
                                        Sign Up
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative z-10 py-12 sm:py-16 lg:py-20 xl:py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    
                    <!-- Left Column - Text Content -->
                    <div class="text-center lg:text-left space-y-6 sm:space-y-8 max-w-2xl mx-auto lg:mx-0 order-2 lg:order-1">
                        
                        <!-- Main Heading -->
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-6xl xl:text-7xl font-bold text-gray-900 leading-tight">
                            Yummy sweets
                            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-pink-600">
                                delivered
                            </span>
                            to your dining table!
                        </h1>
                        
                        <!-- Subheading -->
                        <p class="text-lg sm:text-xl md:text-2xl text-gray-700 leading-relaxed font-medium">
                            Freshly baked happiness, just a click away.
                            <br>
                            <span class="text-red-500">Celebration starts with our cakes.</span>
                        </p>

                        <!-- Features List -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-center lg:justify-start gap-4 sm:gap-6 pt-4">
                            <div class="flex items-center space-x-2">
                                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 font-medium">Fresh Daily</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 font-medium">Fast Delivery</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 font-medium">Premium Quality</span>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" 
                                       class="group inline-flex items-center justify-center bg-gradient-to-r from-red-500 to-red-600 text-white font-bold px-10 py-4 rounded-full shadow-xl hover:shadow-2xl hover:from-red-600 hover:to-red-700 transform hover:-translate-y-1 transition-all duration-300 text-base sm:text-lg">
                                        <span>Go to Dashboard</span>
                                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </a>
                                @else
                                    <a href="{{ route('register') }}" 
                                       class="group inline-flex items-center justify-center bg-gradient-to-r from-red-500 to-red-600 text-white font-bold px-10 py-4 rounded-full shadow-xl hover:shadow-2xl hover:from-red-600 hover:to-red-700 transform hover:-translate-y-1 transition-all duration-300 text-base sm:text-lg">
                                        <span>Order Now</span>
                                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </a>

                                    <a href="{{ route('login') }}" 
                                       class="inline-flex items-center justify-center border-3 border-red-500 bg-white text-red-600 font-bold px-10 py-4 rounded-full hover:bg-red-50 hover:border-red-600 transform hover:-translate-y-1 transition-all duration-300 text-base sm:text-lg shadow-lg">
                                        Explore Menu
                                    </a>
                                @endauth
                            @endif
                        </div>

                        <!-- Trust Indicators -->
                        <div class="flex items-center justify-center lg:justify-start gap-8 pt-8 text-sm text-gray-600">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-red-500">500+</div>
                                <div>Happy Customers</div>
                            </div>
                            <div class="h-12 w-px bg-gray-300"></div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-red-500">4.9★</div>
                                <div>Average Rating</div>
                            </div>
                            <div class="h-12 w-px bg-gray-300"></div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-red-500">50+</div>
                                <div>Cake Varieties</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Image -->
                    <div class="order-1 lg:order-2 flex items-center justify-center relative">
                        <div class="relative">
                            <!-- Background Circle -->
                            <div class="absolute inset-0 bg-gradient-to-br from-red-200 to-pink-200 rounded-full blur-3xl opacity-50 transform scale-110"></div>
                            
                            <!-- Main Image -->
                            <div class="relative bg-white rounded-3xl shadow-2xl p-8 transform hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('images/landing.png') }}" 
                                     alt="Delicious Cupcakes" 
                                     class="w-full h-auto object-contain max-w-sm sm:max-w-md lg:max-w-lg xl:max-w-xl mx-auto drop-shadow-2xl">
                                
                                <!-- Floating Badge -->
                                <div class="absolute -top-4 -right-4 bg-red-500 text-white rounded-full p-4 shadow-xl animate-bounce">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold">20%</div>
                                        <div class="text-xs">OFF</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="relative z-10 py-12 sm:py-16 bg-white/50 backdrop-blur-sm">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <!-- Feature 1 -->
                    <div class="text-center p-6 rounded-2xl bg-white shadow-lg hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Same Day Delivery</h3>
                        <p class="text-gray-600">Order before 2 PM for same-day delivery</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="text-center p-6 rounded-2xl bg-white shadow-lg hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">100% Fresh</h3>
                        <p class="text-gray-600">Baked fresh daily with premium ingredients</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="text-center p-6 rounded-2xl bg-white shadow-lg hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Custom Orders</h3>
                        <p class="text-gray-600">Personalized cakes for your special moments</p>
                    </div>

                </div>
            </div>
        </section>

    </div>

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>

</body>
</html>