@props([
    'colspan' => 0,
    'class' => 'p-3 align-middle'
])

<td
    colspan="{{ $colspan }}"
    class="{{ $class }}"
>
    {{ $slot }}
</td>
