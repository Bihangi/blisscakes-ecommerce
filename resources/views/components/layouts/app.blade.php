<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!--LivewireScripts -->
    @livewireScripts

    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @if(auth()->check() && auth()->user()->user_type === 'admin')
            <!-- Admin Navigation -->
            <nav class="bg-white border-b border-gray-100 shadow-sm">
                <div class="container mx-auto px-4 sm:px-6 lg:px-16 xl:px-24">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-pink-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-birthday-cake text-white text-xl"></i>
                                    </div>
                                    <span class="text-xl font-bold text-slate-900">BlissCakes Admin</span>
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                                    <i class="fas fa-home mr-2"></i>Dashboard
                                </x-nav-link>
                                <x-nav-link href="{{ route('admin.orders') }}" :active="request()->routeIs('admin.orders')">
                                    <i class="fas fa-shopping-bag mr-2"></i>Orders
                                </x-nav-link>
                                <x-nav-link href="{{ route('admin.cakes') }}" :active="request()->routeIs('admin.cakes')">
                                    <i class="fas fa-birthday-cake mr-2"></i>Cakes
                                </x-nav-link>
                                <x-nav-link href="{{ route('admin.categories') }}" :active="request()->routeIs('admin.categories')">
                                    <i class="fas fa-tags mr-2"></i>Categories
                                </x-nav-link>
                                <x-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
                                    <i class="fas fa-users mr-2"></i>Users
                                </x-nav-link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-user text-white text-xs"></i>
                                                </div>
                                                <span>{{ Auth::user()->name }}</span>
                                            </div>
                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="block px-4 py-2 text-xs text-gray-400 border-b">
                                            Admin Account
                                        </div>


                                        <div class="border-t border-gray-200"></div>

                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('admin.logout') }}" x-data>
                                            @csrf
                                            <x-dropdown-link href="{{ route('admin.logout') }}"
                                                    @click.prevent="$root.submit();">
                                                <i class="fas fa-sign-out-alt mr-2"></i>Log Out
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <x-responsive-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                            <i class="fas fa-home mr-2"></i>Dashboard
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="{{ route('admin.orders') }}" :active="request()->routeIs('admin.orders')">
                            <i class="fas fa-shopping-bag mr-2"></i>Orders
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="{{ route('admin.cakes') }}" :active="request()->routeIs('admin.cakes')">
                            <i class="fas fa-birthday-cake mr-2"></i>Cakes
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="{{ route('admin.categories') }}" :active="request()->routeIs('admin.categories')">
                            <i class="fas fa-tags mr-2"></i>Categories
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
                            <i class="fas fa-users mr-2"></i>Users
                        </x-responsive-nav-link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div class="shrink-0 mr-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <x-responsive-nav-link href="{{ route('profile.show') }}">
                                <i class="fas fa-user-circle mr-2"></i>Profile
                            </x-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('admin.logout') }}" x-data>
                                @csrf
                                <x-responsive-nav-link href="{{ route('admin.logout') }}"
                                        @click.prevent="$root.submit();">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Log Out
                                </x-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        @else
            <!-- Regular User Navigation (if needed) -->
            @livewire('navigation-menu')
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>
</html>