@props([
    'class' => 'min-w-full text-sm text-gray-700 bg-white text-center'
])

<table
    class="{{ $class }}"
>
    {{ $slot }}
</table>
