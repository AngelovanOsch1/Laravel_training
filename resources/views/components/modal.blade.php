@props([
    'buttonText' => '',
    'title' => '',
    'description' => '',
    'closeButtonText' => '',
    'saveButtonText' => '',
    'submitForm' => ''
])

<div class="relative z-10">
    <x-primary-button
        type="button"
        text='{{ $buttonText }}'
        xclick='$refs.modal.showModal()'
    />

    <dialog 
        x-ref="modal" 
        x-on:click="$event.target === $refs.modal && $refs.modal.close()"
        class="backdrop:bg-black/50 rounded-lg p-6 max-w-md w-full m-auto"
    >
        <form class="flex flex-col" wire:submit.prevent="{{ $submitForm }}">
            <h2 class="text-lg font-semibold">{{ $title }}</h2>
            <p>{{ $description }}</p>

            {{ $slot }}

            <div class="flex justify-between mt-4">
                <x-primary-button
                    type="button"
                    text='{{ $closeButtonText }}'
                    class='
                        text-gray-700 bg-gray-200 hover:bg-gray-300
                        focus:outline-none focus:ring-2 focus:ring-gray-400
                        font-medium rounded-lg text-sm
                        px-5 py-2.5 w-full sm:w-auto text-center
                        dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 dark:focus:ring-gray-500
                        shadow-sm transition-colors duration-150
                    '
                    xclick='$refs.modal.close()'
                />
                <x-primary-button
                    text='{{ $saveButtonText }}'
                    click='submit'
                />
            </div>
        </form>
    </dialog>
</div>
