<div class="flex gap-5 mb-8">
    <x-nav-link class="" href="{{ route('profile', ['id' => $comment->user->id]) }}">
        <label class="relative inline-block h-15 w-15 cursor-pointer group">
            <img src="{{ asset('storage/' . ($comment->user->profile_photo ?? 'images/default_profile_photo.png')) }}"
                class="absolute inset-0 w-full h-full object-cover rounded-xl pointer-events-none" alt="profile-photo" />
        </label>
    </x-nav-link>

    <div class="flex justify-between items-start w-full">
        <div class="w-full">
            <div class="flex gap-2 items-center">
                <h5>{{ $comment->user->first_name . ' ' . $comment->user->last_name }}</h5>
                <div class="text-xs text-gray-400 font-light">{{ $comment->created_at->diffForHumans() }}</div>
                @if ($comment->is_edited)
                    <div class="text-xs text-gray-400 font-light">(edited)</div>
                @endif
            </div>

            <div class="mt-3">
                @if (!$isEditing)
                    <div>
                        <p>{{ $comment->message }}</p>
                        @if ($comment->photo)
                            <img src="{{ asset('storage/' . $comment->photo) }}" class="w-24 h-24 rounded-xl mt-4"
                                alt="comment-photo" />
                        @endif
                    </div>
                @endif

                @if ($isEditing)
                    <div>
                        <x-form-textarea id="message" name="form.message" placeholder="Enter up to 300 characters..."
                            rows="0" liveModel="form.message" maxCharacters="300" :fileUpload="true"
                            :value="$comment->photo"
                            class="w-full text-sm border-0 border-b border-gray-300 focus:border-teal-600 focus:ring-0 placeholder-gray-400 pt-2 resize-none focus:outline-none" />
                        @if ($comment->photo)
                            <div class="relative flex items-center gap-4 mb-4">
                                <div class="relative">
                                    <img src="{{ $form->photo ? $form->photo?->temporaryUrl() : asset('storage/' . $comment->photo) }}"
                                        class="w-24 h-24 rounded-xl" alt="comment-photo" />
                                </div>

                                <div>
                                    <label class="cursor-pointer text-sm text-teal-600 hover:text-teal-500 font-medium">
                                        Upload Photo
                                        <input type="file" wire:model="form.photo" class="hidden" />
                                    </label>
                                </div>
                            </div>
                        @endif

                        <div class="flex gap-2">
                            <x-primary-button
                                class="text-white font-medium rounded-lg text-sm w-full sm:w-auto px-3 py-1 text-center bg-teal-600 hover:bg-teal-500 cursor-pointer min-w-[65px]"
                                click="updateComment({{ $comment->id }})" text="Save" type="button" />
                            <x-primary-button
                                class="font-medium rounded-lg text-sm px-3 py-1 w-full sm:w-auto text-center bg-gray-700 text-gray-200 hover:bg-gray-600 cursor-pointer min-w-[65px]"
                                click="closeEditing" text="Cancel" type="button" />
                        </div>
                    </div>
                @endif
            </div>

            @if (!$isEditing)
                <div class="mt-3 flex gap-5">
                    <div class="flex gap-2 items-center cursor-pointer select-none"
                        wire:click="like({{ $comment->id }})" x-data="{ liked: false }"
                        x-on:click="liked = true;setTimeout(() => liked = false, 300);">
                        <i :class="(liked ? 'fa fa-thumbs-up' :
                            '{{ $comment->authUserReactedWith('like') ? 'fa fa-thumbs-up' : 'fa fa-thumbs-o-up' }}') +' fa-fw animate-scale-up'"
                            class="transition-transform" style="width: 1.25rem; text-align: center;"></i>
                        <p>{{ $comment->likes_count }}</p>
                    </div>

                    <div class="flex gap-2 items-center cursor-pointer select-none"
                        wire:click="dislike({{ $comment->id }})" x-data="{ disliked: false }"
                        x-on:click="disliked = true; setTimeout(() => disliked = false, 300);">
                        <i :class="(disliked ? 'fa fa-thumbs-down' :
                            '{{ $comment->authUserReactedWith('dislike') ? 'fa fa-thumbs-down' : 'fa fa-thumbs-o-down' }}') + ' fa-fw animate-scale-up'"
                            class="transition-transform" style="width: 1.25rem; text-align: center;"></i>
                        <p>{{ $comment->dislikes_count }}</p>
                    </div>

                    <div class="flex gap-2 items-center cursor-pointer">
                        <i class="fa fa-comment-o fa-fw"></i>
                        <p>0</p>
                    </div>
                </div>
            @endif
        </div>

        @if (auth()->id() === $comment->user->id && !$isEditing)
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="px-2 py-1 cursor-pointer" type="button">
                    <i class="fa fa-ellipsis-v pt-3"></i>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-28 bg-white border border-gray-300 rounded shadow-lg z-10">
                    <x-primary-button class="flex items-center w-full px-4 py-2 hover:bg-gray-100 gap-3"
                        xClick="open = false; isEditing = true;" click="editComment({{ $comment->id }})"
                        text="Edit" icon="edit" type="button" />
                    <x-primary-button class="flex items-center w-full px-4 py-2 hover:bg-gray-100 text-red-600 gap-3"
                        click="openDeleteCommentModal({{ $comment->id }})" text="Delete" icon="trash"
                        type="button" />
                </div>
            </div>
        @endif
    </div>
</div>
