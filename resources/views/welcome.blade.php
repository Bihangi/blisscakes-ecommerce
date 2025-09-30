<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bliss Cake') }} - Freshly Baked Happiness</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

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
    <div class="min-h-screen flex flex-col relative overflow-hidden bg-[#FADBD8]">
        
        <!-- Logo - Top Right Corner -->
        <div class="absolute top-4 right-4 sm:top-6 sm:right-6 md:top-8 md:right-10 z-50">
            <img src="{{ asset('images/logo.png') }}" alt="Bliss Cake" class="w-14 sm:w-16 md:w-20 lg:w-24 drop-shadow-lg">
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex items-center relative z-10">
            <div class="w-full">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 xl:gap-16 items-center py-16 sm:py-20 lg:py-0 min-h-screen lg:min-h-0">
                        
                        <!-- Left Column - Text Content -->
                        <div class="order-2 lg:order-1 text-center lg:text-left space-y-6 sm:space-y-8 max-w-xl mx-auto lg:mx-0 lg:pr-8">
                            
                            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-5xl xl:text-6xl 2xl:text-7xl font-bold text-gray-900 leading-tight">
                                Yummy sweets delivered
                                <br class="hidden sm:inline">
                                to your dining table!
                            </h1>
                            
                            <p class="text-base sm:text-lg md:text-xl lg:text-lg xl:text-xl text-gray-800 leading-relaxed font-normal">
                                Freshly baked happiness, just a click away.
                                <br>
                                Celebration starts with our cakes.
                            </p>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center lg:justify-start pt-2">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/dashboard') }}" 
                                           class="inline-flex items-center justify-center bg-red-500 text-white font-semibold px-8 sm:px-10 py-3.5 sm:py-4 rounded-lg shadow-lg hover:bg-red-600 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base">
                                            DASHBOARD
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" 
                                           class="inline-flex items-center justify-center border-2 border-red-500 bg-white text-red-600 font-semibold px-8 sm:px-10 py-3.5 sm:py-4 rounded-lg hover:bg-red-50 hover:border-red-600 transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base">
                                            LOGIN
                                        </a>

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" 
                                               class="inline-flex items-center justify-center bg-red-500 text-white font-semibold px-8 sm:px-10 py-3.5 sm:py-4 rounded-lg shadow-lg hover:bg-red-600 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base">
                                                SIGNUP
                                            </a>
                                        @endif
                                    @endauth
                                @endif
                            </div>
                        </div>

                        <!-- Right Column - Image -->
                        <div class="order-1 lg:order-2 flex items-center justify-center relative">
                            <div class="w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl">
                                <img src="{{ asset('images/landing.png') }}" 
                                     alt="Delicious Cupcakes" 
                                     class="w-full h-auto object-contain drop-shadow-2xl">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Curved Background Wave -->
        <div class="absolute bottom-0 left-0 right-0 w-full h-[30vh] sm:h-[35vh] md:h-[40vh] lg:h-[45vh] xl:h-[50vh] bg-[#FDEDEC] pointer-events-none"
             style="border-radius: 50% 50% 0 0 / 10% 10% 0 0; z-index: 0;">
        </div>
    </div>

</body>
</html>
