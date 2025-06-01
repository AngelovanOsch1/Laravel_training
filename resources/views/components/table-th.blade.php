@props([
    'class' => 'p-3 text-left',
    'cursorPointer' => false,
    'click' => null,
])

<th class="{{ $class }} {{ $cursorPointer ? ' cursor-pointer' : '' }}" wire:click="{{ $click }}">
    {{ $slot }}
</th>
