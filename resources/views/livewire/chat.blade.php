<div class="mt-10">
    <div class="flex bg-gray-100 rounded-lg shadow-lg w-full overflow-hidden shadow-[#c0c0c0]">
        <!-- Chat list with fixed width -->
        <div class="w-[350px]">
            <livewire:chat-list :loggedInUser="$loggedInUser" />
        </div>

        <!-- Chat screen with remaining width -->
        <div class="flex-grow">
            <livewire:chat-screen />
        </div>
    </div>
</div>
