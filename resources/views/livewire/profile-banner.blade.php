<div>
    <label class="relative w-full h-64 block group {{ auth()->id() !== $user->id ? 'cursor-default' : 'cursor-pointer' }}">
        @if (auth()->id() === $user->id)
            <input type="file" class="hidden" wire:model="form.photo" />
        @endif
        <img src="{{ asset('storage/' . $profileBanner) }}"
            class="absolute inset-0 w-full h-full object-cover rounded-xl pointer-events-none" alt="profile-banner" />

        <div
            class="absolute inset-0 rounded-xl transition-opacity duration-300
            {{ auth()->id() === $user->id ? 'bg-black opacity-0 group-hover:opacity-30' : 'pointer-events-none' }}">
        </div>
        @if (auth()->id() === $user->id)
            <div
                class="absolute bottom-6 left-6 text-white text-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                Click to upload
            </div>
        @endif
    </label>
</div>
