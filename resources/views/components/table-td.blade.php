@props([
    'colspan' => 0,
    'class' => 'p-4',
])

<td colspan="{{ $colspan }}" class="{{ $class }}">
    {{ $slot }}
</td>
