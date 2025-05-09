@props([
    'type' => 'submit',
    'text',
    'click' => null,
    'xclick' => null,
    'icon' => null,
    'iconPosition' => 'left',
    'class' => 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center gap-3'
])
<button 
    type="{{ $type }}"
    wire:click="{{ $click }}"
    x-on:click="{{ $xclick }}"
    wire:navigate
    class="{{ $class }}"
    style="flex-direction: {{ $iconPosition === 'right' ? 'row-reverse' : 'row' }}"
>
    @if ($icon)
        <i class="{{ 'fa fa-' . $icon }} fa-sm"></i>
    @endif

    {{ $text }}
</button>
