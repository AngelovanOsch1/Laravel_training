@props([
    'class' => '',
])

<th
    class="{{ $class }}"
>
    {{ $slot }}
</th>
