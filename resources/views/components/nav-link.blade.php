@props([
    'href' => '',
    'text' => '',
    'active' => false,
    'activeClass' => '',
    'class' => 'text-white bg-teal-600 hover:bg-teal-700 focus:ring-4 focus:outline-none focus:ring-teal-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-teal-600 dark:hover:bg-teal-500 dark:focus:ring-teal-800',
])

<a
    href="{{ $href }}"
    class="{{ $class }} {{ $active ? $activeClass : $class }}"
    wire:navigate
>
    {{ $text }}
</a>
