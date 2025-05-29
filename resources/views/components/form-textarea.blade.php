@props([
    'id' => '',
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'model' => null,
    'rows' => "5",
    'maxCharacters' => 250,
    'class' => 'border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white resize-none',
])

<textarea
    id="{{ $id }}"
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    wire:model="{{ $model }}"
    rows="{{ $rows }}"
    class="{{ $class }}"
></textarea>
<p
    class="text-right text-sm mt-2 text-gray-500"
    :class="{ 'text-red-500': $wire.{{ $model }}.length > {{ $maxCharacters }} }"
>
    <span x-text="$wire.{{ $model }}.length"></span> / {{ $maxCharacters }}
</p>
@error($name)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
