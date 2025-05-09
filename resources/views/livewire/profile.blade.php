<div>
    <x-profile-banner />   
    <div class="flex justify-between w-full gap-x-25">
        <x-profile-card class="w-1/3" />      
        <div class="flex-grow">
            <livewire:serie-statistics />
            <div class="mt-6">
                <livewire:user-highest-rated-entries />
            </div>
        </div>
    </div>
    <livewire:edit-profile />