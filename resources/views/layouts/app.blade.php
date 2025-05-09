<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @vite('resources/css/app.css')
  @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
  <livewire:header /> 
  <main class="flex-1 container mx-auto p-4 mt-12">
    {{ $slot }}
  </main>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  @livewireScripts
  @vite('resources/js/app.js')
</body>
</html>
