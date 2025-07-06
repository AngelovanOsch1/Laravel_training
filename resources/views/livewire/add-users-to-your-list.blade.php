<div x-data x-init="$watch('$wire.show', value => window.toggleBodyScroll(value))">
    @if ($show)
    <div class="fixed inset-0 z-50 bg-gray-800/25 flex justify-center items-center" @click="$wire.closeModal()">
        <div class="flex flex-col p-6 bg-white relative min-h-[500px] h-[500px] min-w-[600px] w-[600px] rounded-lg shadow-lg"
            @click.stop>
            <div class="flex flex-col overflow-y-auto scrollbar-hidden">

                <x-form-input type="search" placeholder="Search users..."
                    class="border border-gray-300 bg-white text-gray-900 text-sm rounded-lg block w-full p-2.5"
                    liveModel="query" icon="search" />
                <hr class="my-6 border-t border-gray-300" />
                <div class="group transition hover:bg-gray-100 rounded-md">
                    <div class="flex items-center px-2 py-3">
                        <x-user-tile :user="$loggedInUser" :isCurrentUser="false" icon="" />
                        <i class="fa fa-plus text-2xl cursor-pointer ml-auto"></i>
                    </div>
                    <hr class="border-t border-gray-300" />
                </div>
                 <div class="group transition hover:bg-gray-100 rounded-md">
                    <div class="flex items-center px-2 py-3">
                        <x-user-tile :user="$loggedInUser" :isCurrentUser="false" icon="" />
                        <i class="fa fa-plus text-2xl cursor-pointer ml-auto"></i>
                    </div>
                    <hr class="border-t border-gray-300" />
                </div>
                 <div class="group transition hover:bg-gray-100 rounded-md">
                    <div class="flex items-center px-2 py-3">
                        <x-user-tile :user="$loggedInUser" :isCurrentUser="false" icon="" />
                        <i class="fa fa-plus text-2xl cursor-pointer ml-auto"></i>
                    </div>
                    <hr class="border-t border-gray-300" />
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
