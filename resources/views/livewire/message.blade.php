<div class="flex animate-fade-in transition duration-300 {{ $message->sender_id === $loggedInUser->id ? 'justify-end' : 'justify-start' }} {{ $activeMessageId === $message->id ? 'bg-gray-100' : 'bg-white' }}">
    <div
        class="flex flex-col gap-1 max-w-[75%] {{ $message->sender_id === $loggedInUser->id ? 'items-end' : 'items-start' }} ">


            <div class="flex gap-3 {{ $message->sender_id === $loggedInUser->id ? 'flex-row-reverse' : 'flex-row' }}">
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
                        <div x-data="{ open: false }"  x-show="!isEditing"
                            class="absolute top-1 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                            @mouseenter="open = true" @mouseleave="open = false">
                            <x-primary-button class="px-2 py-1 text-gray-400 hover:text-gray-600" type="button"
                                icon="ellipsis-v" />
                            <div x-show="open" x-transition
                                class="absolute right-4 bottom-5 w-28 bg-white border border-gray-300 rounded shadow-lg z-30">
                                <x-primary-button class="flex items-center w-full px-4 py-2 hover:bg-gray-100 gap-3"
                                    xClick="isEditing = true;" click="editMessage({{ $message->id }})" text="Edit" icon="edit"
                                    type="button" />
                                <x-primary-button
                                    class="flex items-center w-full px-4 py-2 hover:bg-gray-100 text-red-600 gap-3"
                                    click="openDeleteMessageModal" text="Delete" icon="trash" type="button" />
                            </div>
                        </div>
                    @endif

                    <div class="text-xs font-semibold text-gray-700">
                        {{ $message->sender->first_name }} {{ $message->sender->last_name }}
                    </div>

                    <div class="text-sm text-gray-900 flex flex-col mt-5 items-start gap-5">
                        @if ($message->photo)
                            <img src="{{ asset('storage/' . $message->photo) }}" class="rounded-lg max-w-xs w-auto h-auto"
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
</div>
