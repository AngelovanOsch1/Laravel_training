@props([
    'type' => 'submit',
    'text' => '',
    'disabled' => false,
    'click' => null,
    'icon' => '',
    'iconPosition' => 'left',
    'class' => 'text-white bg-teal-600 hover:bg-teal-700 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-teal-600 dark:hover:bg-teal-500 inline-flex items-center gap-3',
])

<button 
    type="{{ $type }}"
    wire:click="{{ $click }}"
    class="{{ $class }}
            {{ $disabled ? '!bg-[#B2DFDB] !cursor-not-allowed' : '' }}
            {{ $iconPosition === 'right' ? 'flex-row-reverse' : 'flex-row' }}"
    :disabled="{{ $disabled }}"
>
    @if ($icon)
        <i class="{{ 'fa fa-' . $icon }} fa-sm"></i>
    @endif

    {{ $text }}
</button>
