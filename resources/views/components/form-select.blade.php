@props([
    'id' => '',
    'name' => '',
    'model' => null,
    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white',
])

<select
    id="{{ $id }}"
    name="{{ $name }}"
    wire:model="{{ $model }}"
    class="{{ $class }}"
>
    {{ $slot }}
</select>

@error($name)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror