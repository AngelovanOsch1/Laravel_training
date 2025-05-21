@props([
    'type' => 'text',
    'id' => '',
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'readOnly' => false,
    'model' => null,
    'liveModel' => null,
    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white',
])

<input
    type="{{ $type }}" 
    id="{{ $id }}" 
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    value="{{ $value }}"
    :readonly="{{ $readOnly }}"
    wire:model="{{ $model }}"
    wire:model.live.debounce.300ms="{{ $liveModel }}"
    class="{{ $class }} {{ $readOnly ? 'bg-gray-200 cursor-not-allowed text-gray-500 dark:!bg-gray-600 dark:!text-gray-400' : '' }}"

/>

@error($name)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
