<div x-data
     x-init="$watch('$wire.show', value => window.toggleBodyScroll(value))">
    @if ($show)
        <div class="fixed inset-0 flex justify-center items-center z-50 bg-gray-800/25">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold">{{ $title }}</h2>
                <hr class="my-3 border-t border-gray-300" />
                <p class="text-sm text-red-600">{{ $body }}</p>
                <div class="flex justify-between mt-6">
                    <x-primary-button type="button" click="closeModal"
                        class="font-medium rounded-lg text-sm
                                px-5 py-2.5 w-full sm:w-auto text-center
                                bg-gray-700 text-gray-200 hover:bg-gray-600
                                shadow-sm transition-colors duration-150 cursor-pointer"
                        text="Close" />
                    @if ($callBackFunction)
                        <x-primary-button type="button" click="confirm"
                            class="rounded-md px-5 py-2.5 text-sm font-medium text-white hover:bg-red-600 bg-red-500 cursor-pointer"
                            text="Confirm" />
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
