@props([
    'class' => 'bg-teal-600 text-white uppercase tracking-wider text-xs'
])

<thead
    class="{{ $class }}"
>
    {{ $slot }}
</thead>
