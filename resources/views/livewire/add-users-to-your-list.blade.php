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

                    @forelse ($userList as $user)
                        <div wire:click="addUserToList({{ $user->id }})"
                            class="group transition hover:bg-gray-100 rounded-md w-full cursor-pointer">
                            <div class="flex items-center px-2 py-3">
                                <x-user-tile :user="$user" :isCurrentUser="false" icon="" />
                                <i class="fa fa-plus text-2xl ml-auto"></i>
                            </div>
                            <hr class="border-t border-gray-300" />
                        </div>
                    @empty
                        <div class="text-gray-500 text-center py-8">
                            No users found.
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    @endif
</div>
