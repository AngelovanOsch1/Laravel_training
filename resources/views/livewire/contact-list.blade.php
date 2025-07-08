<div class="flex flex-col p-6 bg-white relative min-h-[900px] h-[900px] min-w-[350px] w-[350px] z-10 rounded-r-xl"
    style="box-shadow: 6px 0 15px rgba(0, 0, 0, 0.08);">

    <div class="flex flex-col overflow-y-auto scrollbar-hidden space-y-2 pb-20">
        <x-user-tile :user="$loggedInUser" :isCurrentUser="true" icon="ellipsis-v" />
        <hr class="border-t border-gray-300 my-5" />

        @forelse ($contacts as $contact)
            <div class="group cursor-pointer" wire:click="openChat({{ $contact->id }})">
                <div
                    class="transition p-3 rounded-lg {{ $activeContactId === $contact->id ? 'bg-teal-100' : 'hover:bg-gray-100' }} animate-fade-in">
                    <x-user-tile :user="$contact->user_one_id === $loggedInUser->id ? $contact->userTwo : $contact->userOne" :contact="$contact" :isCurrentUser="false" icon="ellipsis-v" />
                </div>
                <hr class="border-t border-gray-300" />
            </div>
        @empty
            <div class="text-gray-500 text-sm text-center py-10">
                No contacts yet. Add someone to start chatting!
            </div>
        @endforelse
    </div>
    <x-primary-button
        class="bg-teal-600 hover:bg-teal-500 text-white shadow-lg rounded-xl px-6 py-3 flex items-center gap-2 text-xl font-medium w-fit h-14 absolute bottom-6 left-6"
        icon="plus" click="openAddUsersToYourListModal" />

    <livewire:add-users-to-your-list :id="$loggedInUser->id" />
</div>
