@props([
    'id' => '',
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'xModel' => null,
    'model' => null,
    'liveModel' => null,
    'rows' => "5",
    'maxCharacters' => 250,
    'class' => 'border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white resize-none',
    'fileUpload' => false,
])

<div>
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        @if ($xModel) x-model="{{ $xModel }}" @endif
        wire:model="{{ $model }}"
        wire:model.live.debounce.300ms="{{ $liveModel }}"
        rows="{{ $rows }}"
        class="{{ $class }}"
    ></textarea>
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
    <div class="flex justify-end text-sm mt-2 text-gray-500 space-x-4">
        <p
            @if ($xModel)
                :class="{ 'text-red-500': {{ $xModel }}.length > {{ $maxCharacters }} }"
            @else
                :class="{ 'text-red-500': ($wire.{{ $model }}?.length ?? 0) > {{ $maxCharacters }} }"
            @endif
            class="flex items-center gap-1"
        >
            <i class="fa fa-font"></i>

            <span
                @if ($xModel)
                    x-text="{{ $xModel }}.length"
                @else
                    x-text="$wire.{{ $model }}?.length ?? 0"
                @endif
            ></span> / {{ $maxCharacters }}
        </p>
        @if($fileUpload)
            <p class="flex items-center gap-1">
                <i class="fa fa-picture-o fa-sm"></i>
                <span>{{ $value ? '1' : '0' }} / 1</span>
            </p>
        @endif
    </div>
</div>
