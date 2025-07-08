@props([
    'id' => '',
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'model' => null,
    'liveModel' => null,
    'function' => null,
    'rows' => "5",
    'showCharacterCount' => true,
    'maxCharacters' => 250,
    'class' => 'border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white resize-none scrollbar-hidden',
    'fileUpload' => false,
])

<div>

</div>
<textarea
    id="{{ $id }}"
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    @if($model) wire:model="{{ $model }}" @endif
    @if($liveModel) wire:model.live="{{ $liveModel }}" @endif
    @if ($function) wire:keydown.enter.prevent="{{ $function }}" @endif
    rows="{{ $rows }}"
    class="{{ $class }}"
></textarea>

@error($name)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror

@if ($showCharacterCount)
    <div class="flex justify-end text-sm mt-2 text-gray-500 space-x-4">
        <p :class="{ 'text-red-500': ($wire.{{ $liveModel }}?.length ?? 0) > {{ $maxCharacters }} }" class="flex items-center gap-1">
            <i class="fa fa-font"></i>
            <span x-text="$wire.{{ $liveModel }}?.length ?? 0"></span> / {{ $maxCharacters }}
        </p>

        @if($fileUpload)
            <p class="flex items-center gap-1">
                <i class="fa fa-picture-o fa-sm"></i>
                <span>{{ $value ? '1' : '0' }} / 1</span>
            </p>
        @endif
    </div>
@endif
