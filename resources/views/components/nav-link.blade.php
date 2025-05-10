@props([
    'href' => '',
    'text' => '',
    'active' => false,
    'class' => 'rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-teal-600 dark:bg-gray-800 dark:text-white dark:hover:text-white/75',
])

<a
    href="{{ $href }}"
    class="{{ $class }} {{ $active ? 'bg-teal-600 text-white dark:bg-teal-500' : '' }}"
    wire:navigate
>
    {{ $text }}
</a>
