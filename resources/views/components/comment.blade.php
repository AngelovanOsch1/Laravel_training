@props([
    'comment' => null,
])

<div class="flex gap-5 mb-8">
    <x-nav-link class="" href="{{ route('profile', ['id' => $comment->user->id]) }}">
        <label class="relative inline-block h-15 w-15 cursor-pointer group">
            <img src="{{ asset('storage/' . ($comment->user->profile_photo ?? 'images/default_profile_photo.png')) }}"
                class="absolute inset-0 w-full h-full object-cover rounded-xl pointer-events-none" alt="profile-photo" />
        </label>
    </x-nav-link>
    <div class="flex justify-between items-center w-full">
        <div>
            <div class="flex gap-3 items-center">
                <h5>{{ $comment->user->first_name . ' ' . $comment->user->last_name }}</h5>
                <div class="text-xs text-gray-400 font-light">{{ $comment->created_at->diffForHumans() }}</div>
            </div>
            <form class="mt-3">
                {{ $comment->message }}
                @if ($comment->image)
                    <img src="{{ asset('storage/' . $comment->image) }}" class="w-24 h-24 rounded-xl mt-4"
                        alt="default-profile-photo" />
                @endif
            </form>
            <div class="mt-3 flex gap-5">
                <div class="flex gap-2 items-center cursor-pointer" wire:click="like({{ $comment->id }})">
                    <i class="fa fa-thumbs-o-up"></i>
                    <p>{{ $comment->likes_count }}</p>
                </div>
                <div class="flex gap-2 items-center cursor-pointer" wire:click="dislike({{ $comment->id }})">
                    <i class="fa fa-thumbs-o-down"></i>
                    <p>{{ $comment->dislikes_count }}</p>
                </div>
                <div class="flex gap-2 items-center cursor-pointer">
                    <i class="fa fa-comment-o"></i>
                    <p>0</p>
                </div>
            </div>
        </div>
        @if (auth()->id() === $comment->user->id)
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="px-2 py-1 cursor-pointer">
                    <i class="fa fa-ellipsis-v"></i>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-28 bg-white border border-gray-300 rounded shadow-lg z-10"
                    x-transition style="display: none;">

                    <button class="flex items-center w-full px-4 py-2 hover:bg-gray-100"
                        @click="open = false; alert('Edit clicked')" title="Edit">
                        <i class="fa fa-edit mr-2"></i>
                        Edit
                    </button>

                    <button class="flex items-center w-full px-4 py-2 hover:bg-gray-100 text-red-600"
                        @click="open = false" wire:click="deleteComment({{ $comment->id }})" title="Delete">
                        <i class="fa fa-trash mr-2"></i>
                        Delete
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
