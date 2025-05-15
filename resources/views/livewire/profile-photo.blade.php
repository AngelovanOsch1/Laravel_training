<div>
    <label class="relative inline-block h-56 w-56 cursor-pointer group">
        <input type="file" class="hidden" wire:model="form.photo" /> 
        @if ($form->photo && $form->photo->isValid() && in_array($form->photo->getClientOriginalExtension(), ['jpeg', 'png', 'webp', 'jpg']))
            <img 
                src="{{ $form->photo->temporaryUrl() }}"
                class="absolute inset-0 w-full h-full object-cover rounded-xl pointer-events-none"
                alt="profile-photo"
            />
        @else
            <img 
                src="{{ asset('storage/' . $profilePhoto) }}"
                class="absolute inset-0 w-full h-full object-cover rounded-xl pointer-events-none"
                alt="default-profile-photo"
            />
        @endif
        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-30 transition-opacity duration-300 rounded-lg pointer-events-none"></div>
        <div class="absolute bottom-3 left-3 text-white text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
            Click to upload
        </div>
    </label>
</div>
