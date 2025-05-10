@props([
    'type' => 'submit',
    'text' => '',
    'click' => null,
    'xclick' => '',
    'icon' => '',
    'iconPosition' => 'left',
    'class' => 'text-white bg-teal-600 hover:bg-teal-700 focus:ring-4 focus:outline-none focus:ring-teal-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-teal-600 dark:hover:bg-teal-500 dark:focus:ring-teal-800 inline-flex items-center gap-3'
])

<button 
    type="{{ $type }}"
    @if (!empty($click)) wire:click="{{ $click }}" @endif
    @if (!empty($xclick)) x-on:click="$wire.{{ $xclick }}" @endif
    wire:navigate
    class="{{ $class }}"
    style="flex-direction: {{ $iconPosition === 'right' ? 'row-reverse' : 'row' }}"
>
    @if ($icon)
        <i class="{{ 'fa fa-' . $icon }} fa-sm"></i>
    @endif

    {{ $text }}
</button>
