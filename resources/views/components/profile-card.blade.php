@props([
    'user' => null,
    'likesObject' => null,
])

<div
    class="my-10 flex flex-col items-center rounded-xl bg-white px-6 py-6 text-center md:max-w-md shadow-lg shadow-[#c0c0c0]">
    <div class="mb-4">
        <livewire:profile-photo :user="$user" />
    </div>
    <div>
        <h2 class="text-xl font-bold text-gray-800">{{ $user->first_name . ' ' . $user->last_name }}</h2>
        <span
            class="inline-block mt-1 rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-700">{{ $user->role->name }}</span>
        <p class="mt-2 text-gray-600 w-[220px] mx-auto text-center break-words">{{ $user->description }}</p>
        <hr class="my-6 border-t border-gray-300" />
        <div class="w-full space-y-4 mt-4">
            <div class="flex justify-between text-sm text-gray-700">
                <span>Date of Birth</span>
                <span>{{ $user->date_of_birth->format('F j, Y') }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-700">
                <span>Gender</span>
                <span>{{ $user->gender->name }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-700">
                <span>Country</span>
                <span>{{ $user->country->name }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-700">
                <span>Joined</span>
                <span>{{ $user->created_at->format('F j, Y') }}</span>
            </div>
        </div>
        <hr class="my-6 border-t border-gray-300" />
        <div class="flex flex-col gap-4 mt-6 w-full">
            <div class="flex gap-4">
                <x-primary-button type="button" text="Likes {{ $likesObject->likeCount }}" :icon="$likesObject->hasalreadyLiked ? 'heart' : 'heart-o'"
                    iconPosition="right" click="likeUser({{ $user->id }})"
                    class="px-4 py-2 bg-pink-300 text-white font-medium rounded shadow hover:bg-pink-400 flex items-center gap-2 text-sm w-full justify-center whitespace-nowrap" />

                <x-primary-button type="button" text="Chat" icon="comments" iconPosition="right"  click="startChatWithUser({{ $user->id }})"
                    class="px-4 py-2 bg-green-300 text-white font-medium rounded shadow hover:bg-green-400 flex items-center gap-2 text-sm w-full justify-center whitespace-nowrap" />
            </div>
            @if (auth()->id() === $user->id)
                <div>
                    <x-primary-button text='Edit profile' icon='edit' iconPosition='right' type="button"
                        click='openEditProfileModal' />
                </div>
            @endif
        </div>
    </div>
    <livewire:edit-profile />

</div>
