@props([
    'id' => '',
    'name' => '',
    'disabled' => false,
    'model' => null,
    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white',
])

<select
    id="{{ $id }}"
    name="{{ $name }}"
    {{ $disabled ? 'disabled' : '' }}
    wire:model="{{ $model }}"
    class="{{ $class }} {{ $disabled ? 'bg-gray-200 cursor-not-allowed text-gray-500 dark:!bg-gray-600 dark:!text-gray-400' : '' }}"
>
    {{ $slot }}
</select>

@error($name)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror