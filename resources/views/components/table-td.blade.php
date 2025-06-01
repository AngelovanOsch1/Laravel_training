@props([
    'colspan' => 0,
    'class' => 'p-3 align-middle text-left',
])

<td colspan="{{ $colspan }}" class="{{ $class }}">
    {{ $slot }}
</td>
