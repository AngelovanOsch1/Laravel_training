<div class="mt-10">
    <div class="flex bg-gray-100 rounded-lg shadow-lg w-full overflow-hidden shadow-[#c0c0c0]">
        <div class="w-[350px]">
            <livewire:contact-list :loggedInUser="$loggedInUser" :activeContactId="$latestContactId" />
        </div>
        <div class="flex-grow">
            <livewire:chat-screen :loggedInUser="$loggedInUser" :latestContactId="$latestContactId" />
        </div>
    </div>
</div>
