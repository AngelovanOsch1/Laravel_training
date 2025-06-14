<div>
    <label class="relative block w-56 aspect-square cursor-pointer group">
        <input type="file" class="hidden" wire:model="form.photo" />
        <img src="{{ asset('storage/' . $profilePhoto) }}"
            class="absolute inset-0 w-full h-full object-cover rounded-xl pointer-events-none"
            alt="default-profile-photo" />
        <div
            class="absolute inset-0 bg-black opacity-0 group-hover:opacity-30 transition-opacity duration-300 rounded-lg pointer-events-none">
        </div>
        <div
            class="absolute bottom-3 left-3 text-white text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
            Click to upload
        </div>
    </label>
</div>
