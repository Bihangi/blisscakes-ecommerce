<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'BlissCakes')</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  @livewireStyles
</head>
<body class="bg-white">

  {{-- header --}}
  @include('layouts.partials.header')

  <main>
    {{-- classic Blade section usage --}}
    @yield('content')

    {{-- If this layout is used as a Blade component / Livewire page component, $slot will exist.
         Use @isset so we don't error when $slot is not provided. --}}
    @isset($slot)
      {{ $slot }}
    @endisset
  </main>

  {{-- footer --}}
  @include('layouts.partials.footer')

  @livewireScripts

  <!-- Axios -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  @stack('scripts')
</body>
</html>
