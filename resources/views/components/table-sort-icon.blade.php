@props([
    'active' => false,
    'direction' => 'desc',
    'class' => 'w-5 h-5 inline-block',
])

<svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
    style="transform: rotate({{ $active && $direction === 'desc' ? '180deg' : '0deg' }});"
    stroke="{{ $active ? '#ffffff' : 'transparent' }}">
    <path
        d="M5 15L10 9.84985C10.2563 9.57616 10.566 9.35814 10.9101 9.20898C11.2541 9.05983 11.625 8.98291 12 8.98291C12.375 8.98291 12.7459 9.05983 13.0899 9.20898C13.434 9.35814 13.7437 9.57616 14 9.84985L19 15"
        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
</svg>
