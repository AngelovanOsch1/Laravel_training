@props([
    'for' => '',
    'text' => '',
    'class' => 'block mb-2 text-sm font-bold'
])

<label 
    for="{{ $for }}" 
    class="{{ $class }}"
>
    {{ $text }}
</label>
