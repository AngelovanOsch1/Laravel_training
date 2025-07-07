<div>
    <label class="relative block w-56 aspect-square group {{ auth()->id() === $user->id ? 'cursor-pointer' : 'cursor-default' }}">
        @if (auth()->id() === $user->id)
            <input type="file" class="hidden" wire:model="form.photo" />
        @endif

        <img src="{{ asset('storage/' . $profilePhoto) }}"
            class="absolute inset-0 w-full h-full object-cover rounded-xl pointer-events-none"
            alt="default-profile-photo" />

        <div class="absolute inset-0 rounded-lg transition-opacity duration-300
            {{ auth()->id() === $user->id ? 'bg-black opacity-0 group-hover:opacity-30' : 'pointer-events-none' }}">
        </div>

        @if (auth()->id() === $user->id)
            <div class="absolute bottom-3 left-3 text-white text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                Click to upload
            </div>
        @endif

        <div class="absolute top-2 right-2 text-xs font-bold px-2 py-0.5 rounded-md shadow uppercase
            {{ $user->is_online ? 'bg-white text-green-600' : 'bg-gray-200 text-gray-300' }}">
            {{ $user->is_online ? 'online' : 'offline' }}
        </div>
    </label>
</div>
