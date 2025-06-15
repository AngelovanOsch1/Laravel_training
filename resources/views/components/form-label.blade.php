@props([
    'for' => '',
    'text' => '',
    'class' => 'block mb-2 text-sm font-bold text-left'
])

<label
    for="{{ $for }}"
    class="{{ $class }}"
>
    {{ $text }}
</label>
