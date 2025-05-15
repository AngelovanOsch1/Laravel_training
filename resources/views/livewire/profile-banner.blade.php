<div>
    <label class="relative w-full h-64 block cursor-pointer group">
        <input type="file" class="hidden" wire:model="form.photo" />  

        @if ($form->photo && $form->photo->isValid() && in_array($form->photo->getClientOriginalExtension(), ['jpeg', 'png', 'webp', 'jpg']))
            <img 
                src="{{ $form->photo->temporaryUrl() }}"
                class="absolute inset-0 w-full h-full object-cover rounded-xl pointer-events-none"
                alt="profile-banner"
            />
        @else
            <img 
                src="{{ asset('storage/' . $profileBanner) }}"
                class="absolute inset-0 w-full h-full object-cover rounded-xl pointer-events-none"
                alt="profile-banner"
            />
        @endif

        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-30 transition-opacity duration-300 rounded-xl pointer-events-none"></div>
        <div class="absolute bottom-6 left-6 text-white text-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
            Click to upload
        </div>
    </label>
</div>
