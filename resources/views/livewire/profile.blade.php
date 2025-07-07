<div>
    <livewire:profile-banner :user="$user" />
    <div class="flex justify-between w-full gap-x-25">
        <x-profile-card
            :user="$user"
            :likesObject="$likesObject"
        />
        <div class="flex-grow">
            <livewire:series-statistics :id="$user->id" />
            <div class="mt-6">
                <livewire:user-highest-rated-entries :id="$user->id" />
            </div>
        </div>
    </div>
    <livewire:comments :id="$user->id" />
</div>
