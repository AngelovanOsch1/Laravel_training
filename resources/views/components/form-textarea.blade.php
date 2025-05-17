@props([
    'id' => '',
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'model' => null,
    'rows' => "5",
    'maxCharacters' => 250,
    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5
           dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
           focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 resize-none',
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