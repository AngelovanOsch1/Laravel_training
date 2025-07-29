<div x-data="{ isEditing: false }" x-on:message-updated.window="isEditing = false" class="bg-white h-full flex flex-col p-8">
    <div class="flex-1 overflow-y-auto pr-1 max-h-[693px] scrollbar-hidden flex flex-col-reverse"
        style="overflow-anchor: none;">
        <div x-intersect.full="$wire.loadMore()" style="order: 1;">

            <div wire:loading wire:target="loadMore">
            </div>
        </div>
        @forelse(collect($messages)->reverse() as $message)
            <div :key="$message->id" class="animate-fade-in transition duration-300 pb-5">
                <div
                    class="flex animate-fade-in transition duration-300
                        {{ $message->sender_id === $loggedInUser->id ? 'justify-end' : 'justify-start' }}
                        {{ $activeMessageId === $message->id ? 'bg-gray-100' : 'bg-white' }}">
                    <div
                        class="flex flex-col gap-1 max-w-[75%] {{ $message->sender_id === $loggedInUser->id ? 'items-end' : 'items-start' }}">
                        <div
                            class="flex gap-3 {{ $message->sender_id === $loggedInUser->id ? 'flex-row-reverse' : 'flex-row' }}">
                            <div class="relative w-8 h-8 flex-shrink-0">
                                <img src="{{ asset('storage/' . ($message->sender->profile_photo ?? 'images/default_profile_photo.png')) }}"
                                    class="absolute inset-0 w-full h-full object-cover rounded-full pointer-events-none"
                                    alt="{{ $message->sender->first_name }} profile photo" />
                            </div>

                            <div @class([
                                'flex flex-col shadow-lg shadow-[#c0c0c0] rounded-xl px-4 py-3 relative pr-12 group',
                                'bg-teal-100' => $message->sender_id === $loggedInUser->id,
                                'bg-gray-100' => $message->sender_id !== $loggedInUser->id,
                            ])>
                                @if (auth()->id() === $message->sender_id)
                                    <div x-data="{ open: false }" x-show="!isEditing"
                                        class="absolute top-1 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                        @mouseenter="open = true" @mouseleave="open = false">
                                        <x-primary-button class="px-2 py-1 text-gray-400 hover:text-gray-600"
                                            type="button" icon="ellipsis-v" />
                                        <div x-show="open" x-transition
                                            class="absolute right-4 bottom-5 w-28 bg-white border border-gray-300 rounded shadow-lg z-30">
                                            <x-primary-button
                                                class="flex items-center w-full px-4 py-2 hover:bg-gray-100 gap-3"
                                                xClick="isEditing = true;" click="editMessage({{ $message->id }})"
                                                text="Edit" icon="edit" type="button" />
                                            <x-primary-button
                                                class="flex items-center w-full px-4 py-2 hover:bg-gray-100 text-red-600 gap-3"
                                                click="openDeleteMessageModal({{ $message->id }})" text="Delete"
                                                icon="trash" type="button" />
                                        </div>
                                    </div>
                                @endif

                                <div class="text-xs font-semibold text-gray-700">
                                    {{ $message->sender->first_name }} {{ $message->sender->last_name }}
                                </div>

                                <div class="text-sm text-gray-900 flex flex-col mt-5 items-start gap-5">
                                    @if ($message->photo)
                                        <img src="{{ asset('storage/' . $message->photo) }}"
                                            class="rounded-lg max-w-xs w-auto h-auto" alt="Attached photo" />
                                    @endif
                                    <p class="flex-1">{{ $message->body }}</p>
                                </div>

                                <div class="absolute bottom-1 right-2 text-[11px] text-gray-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}
                                </div>
                            </div>
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

    </div>

    @if (isset($messages) && $messages !== null)
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
                        :showCharacterCount="false" rows="4" function="submit" model="form.message"
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
                        text="{{ $isEditing ? 'Edit' : 'Send' }}" />
                </div>
            </div>
        </form>
    @endif
</div>
