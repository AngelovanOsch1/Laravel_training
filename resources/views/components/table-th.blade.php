@props([
    'class' => 'p-3 font-bold align-middle',
    'cursorPointer' => false,
    'click' => null
])

<th
    class="{{ $class }} {{ $cursorPointer ? ' cursor-pointer' : '' }}"
    wire:click="{{ $click }}"
>
    {{ $slot }}
</th>
