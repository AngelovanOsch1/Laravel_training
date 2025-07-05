<div>
    <div class="flex gap-5 mb-8">
        <x-nav-link class="" href="{{ route('profile', ['id' => $comment->user->id]) }}">
            <label class="relative inline-block h-15 w-15 cursor-pointer group">
                <img src="{{ asset('storage/' . ($comment->user->profile_photo ?? 'images/default_profile_photo.png')) }}"
                    class="absolute inset-0 w-full h-full object-cover rounded-xl pointer-events-none"
                    alt="profile-photo" />
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
                            <x-form-textarea id="message" name="updateCommentform.message"
                                placeholder="Enter up to 300 characters..." rows="0"
                                liveModel="updateCommentform.message" maxCharacters="300" :fileUpload="$comment->photo ? true : false"
                                :value="$comment->photo"
                                class="w-full text-sm border-0 border-b border-gray-300 focus:border-teal-600 focus:ring-0 placeholder-gray-400 pt-2 resize-none focus:outline-none" />
                            @if ($comment->photo)
                                <div class="relative flex items-center gap-4 mb-4">
                                    <div class="relative">
                                        <img src="{{ $updateCommentform->photo ? $updateCommentform->photo?->temporaryUrl() : asset('storage/' . $comment->photo) }}"
                                            class="w-24 h-24 rounded-xl" alt="comment-photo" />
                                    </div>

                                    <div>
                                        <label
                                            class="cursor-pointer text-sm text-teal-600 hover:text-teal-500 font-medium">
                                            Upload Photo
                                            <input type="file" wire:model="updateCommentform.photo" class="hidden" />
                                        </label>
                                    </div>
                                </div>
                            @endif

                            <div class="flex gap-2">
                                <x-primary-button
                                    class="text-white font-medium rounded-lg text-sm w-full sm:w-auto px-3 py-1 text-center bg-teal-600 hover:bg-teal-500 min-w-[65px]"
                                    click="updateComment" text="Save" :disabled="empty($updateCommentform->message || $comment->photo)" type="button" />
                                <x-primary-button
                                    class="font-medium rounded-lg text-sm px-3 py-1 w-full sm:w-auto text-center bg-gray-700 text-gray-200 hover:bg-gray-600 min-w-[65px]"
                                    xClick="isEditing = false" click="isEditingState(false)" text="Cancel"
                                    type="button" />
                            </div>
                        </div>
                    @endif
                </div>

                @if (!$isEditing)
                    <div class="mt-3 flex gap-5">
                        <div class="flex gap-2 items-center cursor-pointer select-none"
                            wire:click="toggleReaction('like')">
                            <i
                                class="{{ $comment->authUserReactedWith('like') ? 'fa fa-thumbs-up' : 'fa fa-thumbs-o-up' }}"></i>
                            <p>{{ $comment->likes_count }}</p>
                        </div>

                        <div class="flex gap-2 items-center cursor-pointer select-none"
                            wire:click="toggleReaction('dislike')">
                            <i
                                class="{{ $comment->authUserReactedWith('dislike') ? 'fa fa-thumbs-down' : 'fa fa-thumbs-o-down' }}"></i>
                            <p>{{ $comment->dislikes_count }}</p>
                        </div>


                        <x-primary-button class="flex gap-2 items-center" click="isReplyingState(true)"
                            xClick="isEditing = true;" icon="comment-o" text="{{ $totalRepliesCount }}"
                            xDisabled="isEditing" />
                    </div>
                @endif
                @if ($isReplying)
                    <div class="mt-8">
                        <div class="flex gap-3">
                            <div>
                                <label class="relative inline-block h-15 w-15 cursor-pointer group">
                                    <img src="{{ asset('storage/' . ($loggedInUser->profile_photo ?? 'images/default_profile_photo.png')) }}"
                                        class="absolute inset-0 w-full h-full object-cover rounded-xl pointer-events-none"
                                        alt="default-profile-photo" />
                                </label>
                            </div>
                            <div class="flex-grow">
                                <x-form-textarea id="message" name="replyForm.message"
                                    placeholder="Enter up to 300 characters..." rows="0"
                                    liveModel="replyForm.message" maxCharacters="300" :fileUpload="true"
                                    :value="$replyForm->photo"
                                    class="w-full text-sm border-0 border-b border-gray-300 focus:border-teal-600 focus:ring-0 placeholder-gray-400 pt-2 resize-none focus:outline-none" />

                                <div class="relative flex items-center gap-4 mb-4">
                                    <div class="relative">
                                        <img src="{{ $replyForm->photo?->temporaryUrl() ?? asset('storage/images/placeholder-image.jpg') }}"
                                            class="w-24 h-24 rounded-xl" alt="comment-photo" />
                                        @if ($replyForm->photo)
                                            <x-primary-button type="button" click="$set('replyForm.photo', null)"
                                                class="absolute top-[-6px] right-[-6px] bg-white border border-gray-300 text-red-600 hover:text-red-300 rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-sm cursor-pointer"
                                                icon="remove" />
                                        @endif
                                    </div>

                                    <div>
                                        <label
                                            class="cursor-pointer text-sm text-teal-600 hover:text-teal-500 font-medium">
                                            Upload Photo
                                            <input type="file" wire:model="replyForm.photo" class="hidden" />
                                        </label>
                                    </div>
                                </div>
                                <div class="flex gap-2 mt-4">
                                    <x-primary-button
                                        class="text-white font-medium rounded-lg text-sm w-full sm:w-auto px-3 py-1 text-center bg-teal-600 hover:bg-teal-500 min-w-[65px]"
                                        click="submitReply" :disabled="empty($replyForm->message || $replyForm->photo)" text="Reply" type="button" />
                                    <x-primary-button
                                        class="font-medium rounded-lg text-sm px-3 py-1 w-full sm:w-auto text-center bg-gray-700 text-gray-200 hover:bg-gray-600 min-w-[65px]"
                                        click="isReplyingState(false)" xClick="isEditing = false;" text="Cancel"
                                        type="button" />
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            @if (auth()->id() === $comment->user->id && !$isEditing && !$isReplying)
                <div x-data="{ open: false }" x-show="!isEditing" class="relative">
                    <x-primary-button xClick="open = !open" class="px-2 py-1" type="button" icon="ellipsis-v" />
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-28 bg-white border border-gray-300 rounded shadow-lg z-10">
                        <x-primary-button class="flex items-center w-full px-4 py-2 hover:bg-gray-100 gap-3"
                            xClick="open = false; isEditing = true;" click="isEditingState(true)" text="Edit"
                            icon="edit" type="button" />
                        <x-primary-button
                            class="flex items-center w-full px-4 py-2 hover:bg-gray-100 text-red-600 gap-3"
                            click="openDeleteCommentModal" text="Delete" icon="trash" type="button" />
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if ($replies->isNotEmpty())
        <div class="relative pl-8 ml-8">
            <div>
                @foreach ($replies as $reply)
                    <div wire:key="{{ $reply->id }}" class="animate-fade-in transition duration-300">
                        <livewire:comment :comment="$reply" :user="$reply->user" :loggedInUser="$loggedInUser" :key="$reply->id" />
                    </div>
                @endforeach
            </div>
            <div class="group">
                @if ($isReplying)
                    <div class="absolute -top-62 left-[0px] w-4 cursor-pointer" wire:click="toggleReplies">
                        <div class="w-0.5 h-65 bg-gray-300 group-hover:bg-teal-500 transition-colors"></div>
                    </div>
                @endif

                <div wire:click="toggleReplies" class="absolute top-0 left-0 h-full w-4 cursor-pointer">
                    <div class="w-0.5 h-full bg-gray-300 group-hover:bg-teal-500 transition-colors"></div>
                </div>
            </div>
        </div>

        @if ($totalRepliesCount > 2)
            <div class="flex gap-2 place-items-center mb-4 pl-5">
                <x-primary-button
                    class="w-6 h-6 rounded-full bg-teal-600 hover:bg-teal-500 text-white text-xs flex items-center justify-center"
                    click="toggleReplies" :icon="$totalRepliesCount > count($replies) ? 'plus' : 'minus'" type="button" />
                <div class="text-xs text-gray-400 font-light">
                    {{ $totalRepliesCount > count($replies) ? 'load more comments' : 'Show less comments' }}</div>
            </div>
        @endif
    @endif
</div>
