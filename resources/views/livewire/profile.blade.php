<div>
    <livewire:profile-banner :profileBanner="$user->profile_banner" /> 
    <div class="flex justify-between w-full gap-x-25">
        <x-profile-card :user="$user" />      
        <div class="flex-grow">
            <livewire:serie-statistics />
            <div class="mt-6">
                <livewire:user-highest-rated-entries />
            </div>
        </div>
    </div>
    <x-primary-button 
        text='Edit profile'
        type="button"
        click='openEditProfileModal'
    />
    <livewire:edit-profile />
</div>
