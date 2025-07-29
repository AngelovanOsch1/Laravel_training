@props([
    'user' => null,
    'isCurrentUser' => false,
    'icon' => '',
    'contact' => null,
])

<div class="flex items-center {{ $isCurrentUser ? 'gap-4' : 'gap-2' }}">
    <label class="relative {{ $isCurrentUser ? 'h-20 w-20' : 'h-12 w-12' }}">
        <img src="{{ asset('storage/' . ($user->profile_photo ?? 'images/default_profile_photo.png')) }}"
            class="absolute inset-0 w-full h-full object-cover rounded-full pointer-events-none" alt="profile-photo" />
        @if (!$isCurrentUser)
            <span
                class="absolute bottom-0 right-0 block h-4 w-4 rounded-full border-2 border-white
                    {{ $user->is_online ? 'bg-green-500' : 'bg-gray-400' }}"
                title="{{ $user->is_online ? 'Online' : 'Offline' }}"></span>
        @endif
    </label>

    <div class="flex flex-col relative">
        <div class="flex items-center gap-2">
            <h2 class="{{ $isCurrentUser ? 'text-xl font-semibold' : 'text-sm font-medium' }}">
                {{ $user->first_name . ' ' . $user->last_name }}
            </h2>
            @if (!$isCurrentUser && $contact?->unread_messages_count > 0)
                <span
                    class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                    {{ $contact->unread_messages_count }}
                </span>
            @endif
        </div>

        @if ($contact && $contact->latestMessage)
            <div class="{{ $isCurrentUser ? 'mt-3' : 'mt-1' }} text-xs">
                {{ $contact->latestMessage->body ?? 'Sent a photo' }}
            </div>
        @elseif ($contact === null)
            <span
                class="{{ $isCurrentUser ? 'mt-3' : 'mt-1' }} px-2 py-0.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 w-fit">
                {{ $user->role->name }}
            </span>
        @endif

    </div>

    @if (!$isCurrentUser && $contact)
        <div x-data="{ open: false }" class="relative ml-auto" @click.stop>
            <x-primary-button xClick="open = !open" class="px-2 py-1" type="button" icon="ellipsis-v" />
            <div x-show="open" @click.away="open = false"
                class="absolute right-5 w-28 bg-white border border-gray-300 rounded shadow-lg z-10">
                <x-nav-link href="{{ route('profile', ['id' => $user->id]) }}"
                    class="flex items-center w-full px-4 py-2 hover:bg-gray-100 gap-3 text-black"
                    @click="openDropdownId = null">
                    <i class="fa fa-id-badge"></i>
                    <span>Profile</span>
                </x-nav-link>
                <x-primary-button class="flex items-center w-full px-4 py-2 hover:bg-gray-100 gap-3"
                    click="toggleVisibility({{ $contact->id }})" xClick="open = false" text="Hide" icon="eye-slash"
                    type="button" />
            </div>
        </div>
    @endif
</div>
