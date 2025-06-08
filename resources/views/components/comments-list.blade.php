@props([
    'form' => null,
    'photoForm' => null,
    'commentsList' => [],
])

<div class="flex w-full flex-col rounded-xl bg-white px-6 py-6 shadow-lg shadow-[#c0c0c0]">
    <h3 class="text-xl font-bold mb-8">Comments ({{ $commentsList->total() }})</h3>
    @auth
        <form class="flex gap-3 mb-10" wire:submit.prevent="submit">
            <div>
                <label class="relative inline-block h-15 w-15 cursor-pointer group">
                    <img src="{{ asset('storage/' . 'images/default_profile_photo.png') }}"
                        class="absolute inset-0 w-full h-full object-cover rounded-xl pointer-events-none"
                        alt="default-profile-photo" />
                </label>
            </div>
            <div class="flex-grow">
                <x-form-textarea id="message" name="form.message" placeholder="Enter up to 300 characters..."
                    rows="0" liveModel="form.message" model="form.message" maxCharacters="300" :fileUpload="true"
                    :value="$photoForm->photo?->temporaryUrl()"
                    class="w-full text-sm border-0 border-b border-gray-300 focus:border-teal-600 focus:ring-0 placeholder-gray-400 pt-2 resize-none focus:outline-none" />

                <div class="flex items-center justify-between h-15">
                    <div class="flex items-center gap-2">
                        <x-primary-button text="Comment" :disabled="empty($form->message)"
                            class="text-white font-medium rounded-full text-sm w-full sm:w-auto px-4 py-2 text-center bg-teal-600 hover:bg-teal-500 inline-flex items-center gap-3 shadow-sm transition-colors duration-200" />
                        <label class="cursor-pointer text-sm text-teal-600 hover:text-teal-500 font-medium">
                            Upload Photo
                            <input type="file" wire:model="photoForm.photo" class="hidden" />
                        </label>
                    </div>
                    @if ($photoForm->photo?->temporaryUrl())
                        <div>
                            <img src="{{ $photoForm->photo?->temporaryUrl() }}" alt="Preview"
                                class="w-12 h-12 rounded-xl" />
                        </div>
                    @endif
                </div>
            </div>
        </form>
    @endauth
    @foreach ($commentsList as $comment)
        <x-comment :comment="$comment" />
    @endforeach
    <div class="mt-auto">
        {{ $commentsList->links('vendor.pagination.tailwind') }}
    </div>
</div>
