<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
    @livewireStyles
  </head>
  <body class="bg-gray-100 min-h-screen flex flex-col">
    <livewire:header />
    <livewire:warning-modal />
    <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 max-w-screen-2xl mt-12">
      {{ $slot }}
    </main>
    <div class="mt-20">
      <livewire:footer />
    </div>
    @if (session()->has('success'))
      <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition
        class="fixed bottom-6 right-6 bg-teal-600 text-white px-5 py-3 rounded-lg shadow-lg z-50"
      >
        {{ session('success') }}
      </div>
    @endif
    @livewireScripts
  </body>
</html>
