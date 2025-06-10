@props([
    'id' => '',
    'name' => '',
    'disabled' => false,
    'model' => null,
    'liveModel' => null,
    'class' => 'border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white',
])

<select
    id="{{ $id }}"
    name="{{ $name }}"
    {{ $disabled ? 'disabled' : '' }}
    wire:model="{{ $model }}"
    wire:model.live="{{ $liveModel }}"
    class="{{ $class }} {{ $disabled ? '!bg-gray-600 cursor-not-allowed !text-gray-400' : '' }}"
>
    {{ $slot }}
</select>

@error($name)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
