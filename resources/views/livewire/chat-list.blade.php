<div
    class="flex flex-col p-6 bg-white relative min-h-[900px] h-[900px] min-w-[350px] w-[350px] z-10 rounded-r-xl"
    style="box-shadow: 6px 0 15px rgba(0, 0, 0, 0.08);"
>
    <div class="flex flex-col overflow-y-auto scrollbar-hidden">
        <x-user-tile :user="$loggedInUser" :isCurrentUser="true" icon="ellipsis-v" />
        <x-user-tile :user="$loggedInUser" :isCurrentUser="false" icon="ellipsis-v" />
        <x-user-tile :user="$loggedInUser" :isCurrentUser="false" icon="ellipsis-v" />
        <x-user-tile :user="$loggedInUser" :isCurrentUser="false" icon="ellipsis-v" />
        <x-user-tile :user="$loggedInUser" :isCurrentUser="false" icon="ellipsis-v" />
    </div>

    <x-primary-button
        class="bg-teal-600 hover:bg-teal-500 text-white shadow-lg rounded-xl px-6 py-3 flex items-center gap-2 text-xl font-medium w-fit h-14 absolute bottom-6 left-6"
        icon="plus"
        click="openAddUsersToYourListModal"
    />

    <livewire:add-users-to-your-list :id="$loggedInUser->id" />
</div>
