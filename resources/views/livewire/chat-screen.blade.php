<div
    x-data
    x-init="$nextTick(() => {
        const el = $refs.chatEnd;
        if (el) el.scrollIntoView({ behavior: 'auto', block: 'end' });
    })"
    x-on:chat-scroll-down.window="
        const el = $refs.chatEnd;
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'end' });
    "
    x-on:chat-opened.window="
        $nextTick(() => {
            const el = $refs.chatEnd;
            if (el) el.scrollIntoView({ behavior: 'auto', block: 'end' });
        });
    "
    class="bg-white h-full flex flex-col p-8"
>
    <div class="flex-1 overflow-y-auto space-y-4 pr-1 max-h-[693px] scrollbar-hidden" style="overflow-anchor: none;">
        @forelse($messages ?? [] as $message)
            <div class="flex animate-fade-in transition duration-300 {{ $message->sender_id === $loggedInUser->id ? 'justify-end' : 'justify-start' }}">
                <div class="flex gap-3 max-w-[75%] {{ $message->sender_id === $loggedInUser->id ? 'flex-row-reverse' : 'flex-row' }}">
                    <div class="relative w-8 h-8 flex-shrink-0">
                        <img src="{{ asset('storage/' . ($message->sender->profile_photo ?? 'images/default_profile_photo.png')) }}"
                             class="absolute inset-0 w-full h-full object-cover rounded-full pointer-events-none"
                             alt="{{ $message->sender->first_name }} profile photo" />
                    </div>

                    <div @class([
                        'flex flex-col rounded-xl px-4 py-3 shadow-sm relative pr-12',
                        'bg-teal-100' => $message->sender_id === $loggedInUser->id,
                        'bg-gray-100' => $message->sender_id !== $loggedInUser->id,
                    ])>
                        <div class="text-xs font-semibold text-gray-700">
                            {{ $message->sender->first_name }} {{ $message->sender->last_name }}
                        </div>

                        <div class="text-sm text-gray-900 whitespace-pre-line flex flex-col mt-5 items-start gap-5">
                            @if ($message->photo)
                                <img src="{{ asset('storage/' . $message->photo) }}"
                                     class="rounded-lg max-w-xs w-auto h-auto"
                                     alt="Attached photo" />
                            @endif
                            <p class="flex-1">{{ $message->body }}</p>
                        </div>

                        <div class="absolute bottom-1 right-2 text-[11px] text-gray-500 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col justify-center items-center h-full text-gray-400">
                <img src="{{ asset('storage/images/chat.png') }}" class="h-32 w-32 mb-4" />
                <span>Start the conversation!</span>
            </div>
        @endforelse

        <div x-ref="chatEnd"></div>
    </div>

    <form wire:submit.prevent="submit" class="gap-4 mt-4 border-t border-gray-300">
        @if ($form->photo?->temporaryUrl())
            <div class="relative w-12 h-12 my-3">
                <img src="{{ $form->photo?->temporaryUrl() }}" alt="Preview"
                     class="w-full h-full rounded-xl object-cover" />

                <x-primary-button type="button" click="$set('form.photo', null)"
                    class="absolute top-[-12px] right-[-6px] bg-white border border-gray-300 text-red-600 hover:text-red-300 rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-sm"
                    icon="remove" />
            </div>
        @endif

        <div class="flex justify-center items-start gap-12 mt-5">
            <div class="flex-grow scrollbar-hidden">
                <x-form-textarea id="message" name="form.message" placeholder="Write a message..."
                    :showCharacterCount="false" :fileUpload="true" rows="4" function="submit"
                    liveModel="form.message"
                    class="w-full text-sm rounded-lg bg-white border border-gray-300 focus:border-teal-600 focus:ring-0 placeholder-gray-500 resize-none p-3 shadow-sm focus:outline-none scrollbar-hidden" />
            </div>

            <div class="flex flex-col items-center gap-5 justify-center">
                <label for="photo-upload"
                    class="w-12 h-12 rounded-full flex items-center justify-center p-0 text-xl bg-teal-600 hover:bg-teal-500 text-white shadow-md cursor-pointer">
                    <i class="fa fa-image"></i>
                </label>
                <input type="file" id="photo-upload" wire:model="form.photo" class="hidden" />

                <x-primary-button
                    class="w-20 px-4 py-2 rounded-lg bg-white border border-teal-600 text-teal-600 hover:bg-teal-50 active:bg-teal-100 transition-colors duration-200 ease-in-out text-sm font-semibold shadow-sm"
                    text="Send" />
            </div>
        </div>
    </form>
</div>
