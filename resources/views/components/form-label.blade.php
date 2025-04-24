@props([
    'for',
    'text',
])

<label 
    for="{{ $for }}" 
    class="block mb-2 text-sm font-bold"
>
    {{ $text }}
</label>
