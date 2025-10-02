<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BlissCakes')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="bg-white">
    
    <!-- Header -->
    @include('layouts.partials.header')
    
    <!-- Main Content -->
    <main>
        @yield('content')
        {{ $slot }}
    </main>
    
    <!-- Footer -->
    @include('layouts.partials.footer')
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Axios for API calls -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    @stack('scripts')
</body>
</html>