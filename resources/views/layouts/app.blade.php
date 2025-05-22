<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
    @livewireScripts
  </body>
</html>
