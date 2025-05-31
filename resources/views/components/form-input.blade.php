@props([
    'type' => 'text',
    'id' => '',
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'readOnly' => false,
    'model' => null,
    'liveModel' => null,
    'class' => 'border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white',
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
    class="{{ $class }} {{ $readOnly ? '!bg-gray-600 cursor-not-allowed !text-gray-400' : '' }}"
/>

@error($name)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
