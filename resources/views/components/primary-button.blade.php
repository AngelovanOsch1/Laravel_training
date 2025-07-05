@props([
    'type' => 'submit',
    'text' => '',
    'xDisabled' => false,
    'disabled' => false,
    'xClick' => null,
    'click' => null,
    'icon' => '',
    'iconPosition' => 'left',
    'class' => 'text-white font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center bg-teal-600 hover:bg-teal-500 inline-flex items-center gap-3',
])

<button
    type="{{ $type }}"
    @if ($xClick) @click="{{ $xClick }}" @endif
    @if ($click) wire:click="{{ $click }}" @endif
    x-bind:class="{ '!cursor-not-allowed': {{ $xDisabled ?? 'false' }} }"
    class="{{ $class }}
    {{ $disabled ? '!bg-[#B2DFDB] !cursor-not-allowed' : 'cursor-pointer' }}
    {{ $iconPosition === 'right' ? 'flex-row-reverse' : 'flex-row' }}"
    @if ($disabled) disabled @endif
    @if($xDisabled) x-bind:disabled="{{ $xDisabled }}" @endif
>
    @if ($icon)
        <i class="{{ 'fa fa-' . $icon }} fa-sm"></i>
    @endif

    {{ $text }}
</button>
