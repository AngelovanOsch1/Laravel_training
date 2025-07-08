<div x-data x-init="$watch('$wire.show', value => window.toggleBodyScroll(value))">
    @if ($show)
        <div class="fixed inset-0 flex justify-center items-center z-50 bg-gray-800/25" @click="$wire.closeModal()">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-[915px] min-h-[610px] h-[610px] flex flex-col overflow-hidden"
                 @click.stop>
                <div class="flex-1 flex flex-col overflow-hidden">
                    <div class="relative w-full">
                        <x-form-input type="search" placeholder="Search users..."
                            class="border border-gray-300 bg-white text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            liveModel="query" icon="search" />
                    </div>
                    @if ($results->isEmpty())
                        <div class="mt-4 text-gray-500 overflow-auto">
                            @if (strlen($query) >= 2)
                                <p>No user found matching "<strong>{{ $query }}</strong>"</p>
                            @else
                                <p>You've already added all users.</p>
                            @endif
                        </div>
                    @else
                        <div class="flex-1 mt-6 overflow-y-auto scrollbar-hidden">
                            <ul class="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-4">
                                @foreach ($results as $user)
                                    <li wire:click="addUserToList({{ $user->id }})"
                                        class="animate-fade-in rounded-lg bg-gray-50 p-4 shadow-lg shadow-[#c0c0c0] hover:bg-gray-100 transition cursor-pointer border border-transparent hover:border-teal-500">
                                        <div class="flex items-center gap-3">
                                            <x-user-tile :user="$user" :isCurrentUser="false" icon="" />
                                            <i class="fa fa-plus text-teal-600 text-xl ml-auto"></i>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <div x-intersect.full="$wire.loadMore()" class="mt-10 flex justify-center">
                                <div wire:loading wire:target="loadMore" class="flex justify-center items-center">
                                    <img src="{{ asset('storage/images/spinner.svg') }}" class="h-10 w-10" />
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
