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
  @livewire('header')
  
  {{-- This is where each page’s content goes --}}
  <main class="flex-1 container mx-auto p-4">
    {{ $slot }}
  </main>

  {{-- Livewire scripts --}}
  @livewireScripts

  {{-- Your app.js (e.g. Alpine) --}}
  @vite('resources/js/app.js')

  {{-- Flowbite JS (Add this script tag here) --}}
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>
