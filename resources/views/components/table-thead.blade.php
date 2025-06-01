@props([
    'class' => '',
])

<thead class="{{ $class }}">
    {{ $slot }}
</thead>
