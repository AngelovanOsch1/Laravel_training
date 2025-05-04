@props([
    'type' => 'text',
    'id' => '',
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'model' => null,
    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5
           dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
           focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500',
])

<input
    type="{{ $type }}" 
    id="{{ $id }}" 
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    value="{{ $value }}"
    wire:model="{{ $model }}"
    class="{{ $class }}"
/>

@error($name)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
