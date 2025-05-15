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

<div 
    x-data="{ 
        description: @entangle($model), 
        max: {{ $maxCharacters }} 
    }" 
    class="relative"
>
    <textarea
        id="{{ $id }}" 
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        wire:model="{{ $model }}"
        rows="{{ $rows }}"
        x-model="{{ $id }}"
        class="{{ $class }}"
    ></textarea>

@error($name)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror

    <div class="text-sm text-right mt-2">
        <span 
            :class="{{ $id }}.length > max ? 'text-red-600 font-semibold' : 'text-gray-500'" 
            x-text="`${description.length} / ${max}`"
        ></span>
    </div>
</div>
