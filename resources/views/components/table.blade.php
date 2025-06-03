@props([
    'class' => 'w-full text-left table-auto min-w-max',
])

<table class="{{ $class }}">
    {{ $slot }}
</table>
