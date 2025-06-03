@props([
    'class' => 'p-4',
    'cursorPointer' => false,
    'click' => null,
])

<th class="{{ $class }} {{ $cursorPointer ? ' cursor-pointer' : '' }}" wire:click="{{ $click }}">
    {{ $slot }}
</th>
