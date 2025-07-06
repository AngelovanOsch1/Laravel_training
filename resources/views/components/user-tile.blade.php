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
    <div class="flex flex-col">
        <h2 class="{{ $isCurrentUser ? 'text-xl font-semibold' : 'text-sm font-medium' }}">
            {{ $user->first_name . ' ' . $user->last_name }}
        </h2>
        @if (!$isCurrentUser && $user->role)
            <span class="mt-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 w-fit">
                {{ $user->role->name }}
            </span>
        @endif
    </div>
    @if (!$isCurrentUser)
        <div x-data="{ open: false }" class="relative ml-auto">
            <x-primary-button xClick="open = !open" class="px-2 py-1" type="button" icon="{{ $icon }}" />
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-28 bg-white border border-gray-300 rounded shadow-lg z-10">
                <x-nav-link href="{{ route('profile', ['id' => $user->id]) }}"
                    class="flex items-center w-full px-4 py-2 hover:bg-gray-100 gap-3 text-black" @click="open = false">
                    <i class="fa fa-id-badge"></i>
                    <span>Profile</span>
                </x-nav-link>
                <x-primary-button class="flex items-center w-full px-4 py-2 hover:bg-gray-100 gap-3"
                    click="hideUser" text="Hide" icon="eye-slash" type="button" />
            </div>
        </div>
    @endif
</div>
