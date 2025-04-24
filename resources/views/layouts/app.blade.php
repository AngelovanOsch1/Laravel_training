<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  {{-- Tailwind via Vite --}}
  @vite('resources/css/app.css')

  {{-- Livewire styles --}}
  @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  {{-- Optional shared header --}}
  @include('components.header')

  {{-- This is where each page’s content goes --}}
  <main class="flex-1 container mx-auto p-4">
    {{ $slot }}  {{-- ✅ this is what Livewire's #[Layout] uses --}}
  </main>

  {{-- Livewire scripts --}}
  @livewireScripts

  {{-- Your app.js (e.g. Alpine) --}}
  @vite('resources/js/app.js')
</body>
</html>
