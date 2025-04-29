@props([
    'href',
    'text',
    'active' => false,
    'class' => 'rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm dark:hover:bg-teal-500',
])

<a
    href="{{ $href }}"
    class="{{ $class }}"\
    wire:navigate
>
    {{ $text }}
</a>
