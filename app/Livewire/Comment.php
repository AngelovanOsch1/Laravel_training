<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Reaction;
use Livewire\Attributes\On;
use App\Traits\HandlesPhotos;
use Livewire\WithFileUploads;
use App\Models\Comment as CommentModel;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Forms\CommentFormValidation;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class Comment extends Component
{
    use WithFileUploads;
    use HandlesPhotos;

    public CommentFormValidation $updateCommentform;
    public CommentFormValidation $replyForm;
    public CommentModel $comment;
    public User $loggedInUser;
    public bool $isEditing = false;
    public Collection $replies;

    public bool $isReplying = false;
    public $totalRepliesCount = 0;
    public $allReplies;
    public $visibleRepliesCount = 2;

    public function mount(CommentModel $comment, User $loggedInUser)
    {
        $this->comment = $comment;
        $this->loggedInUser = $loggedInUser;

        $this->loadReplies(2);
    }

    public function render()
    {
        $this->comment = CommentModel::withCount([
            'reactions as likes_count' => fn($query) => $query->where('type', 'like'),
            'reactions as dislikes_count' => fn($query) => $query->where('type', 'dislike'),
        ])
            ->find($this->comment->id);

        return view('livewire.comment');
    }

    public function updatedupdateCommentform()
    {
        try {
            $this->updateCommentform->validateOnly('photo');
        } catch (ValidationException $e) {
            $this->updateCommentform->reset('photo');
            $this->dispatch('openWarningModal', [
                'body' => $e->getMessage(),
            ]);
        }
    }

    public function updatedreplyForm()
    {
        try {
            $this->replyForm->validateOnly('photo');
        } catch (ValidationException $e) {
            $this->replyForm->reset('photo');
            $this->dispatch('openWarningModal', [
                'body' => $e->getMessage(),
            ]);
        }
    }

    public function updateComment()
    {
        $this->updateCommentform->validate();

        if ($this->updateCommentform->photo) {
            $path = $this->uploadPhoto($this->updateCommentform->photo, 'commentsPhotos');
            $this->deletePhoto($this->comment->photo);
        }

        $this->comment->update([
            'message' => $this->updateCommentform->message,
            'photo' => $path ?? $this->comment->photo,
            'is_edited' => true
        ]);

        $this->isEditingState(false);
        $this->dispatch('comment-updated');
    }

    public function openDeleteCommentModal()
    {
        $data = [
            'body' => 'Are you sure you want to delete this comment?',
            'callBackFunction' => 'deleteComment',
            'callBackFunctionParameter' => $this->comment->id
        ];
        $this->dispatch('openWarningModal', $data);
    }

    public function toggleReaction(string $type)
    {
        $existingReaction = Reaction::where('user_id', $this->loggedInUser->id)
            ->where('reactionable_id', $this->comment->id)
            ->where('reactionable_type', CommentModel::class)
            ->first();

        if ($existingReaction) {
            if ($existingReaction->type === $type) {
                $existingReaction->delete();
            } else {
                $existingReaction->type = $type;
                $existingReaction->save();
            }
        } else {
            Reaction::create([
                'user_id' => $this->loggedInUser->id,
                'reactionable_id' => $this->comment->id,
                'reactionable_type' => CommentModel::class,
                'type' => $type,
            ]);
        }
        $this->isEditingState(false);
    }

    public function loadReplies()
    {
        $this->allReplies = $this->comment->replies()
            ->withCount([
                'reactions as likes_count' => fn($q) => $q->where('type', 'like'),
                'reactions as dislikes_count' => fn($q) => $q->where('type', 'dislike'),
            ])
            ->get();

        $this->totalRepliesCount = $this->allReplies->count();
        $this->updateVisibleReplies();
    }

    public function loadMoreReplies()
    {
        $this->visibleRepliesCount += 2;
        $this->updateVisibleReplies();
    }

    protected function updateVisibleReplies()
    {
        $this->replies = $this->allReplies->take($this->visibleRepliesCount);
    }

    public function toggleReplies()
    {
        if ($this->visibleRepliesCount >= $this->totalRepliesCount) {
            $this->visibleRepliesCount = 2;
        } else {
            $this->visibleRepliesCount += 2;
        }

        $this->updateVisibleReplies();
    }

    public function submitReply()
    {
        $this->replyForm->validate();

        if ($this->replyForm->photo) {
            $path = Storage::disk('public')->put('commentsPhotos', $this->replyForm->photo);
        }

        CommentModel::create([
            'message' => $this->replyForm->message,
            'commentable_id' => $this->comment->commentable_id,
            'commentable_type' => $this->comment->commentable_type,
            'photo' => $path ?? null,
            'user_id' => $this->loggedInUser->id,
            'parent_id' => $this->comment->id,
        ]);

        $this->loadReplies();
        $this->dispatch('comment-updated');
        $this->isReplyingState(false);
    }

    #[On('childCommentDeleted.{comment.id}')]
    public function onChildCommentDeleted()
    {
        $this->comment->refresh();
    }

    public function isEditingState(bool $editState)
    {
        $this->isEditing = $editState;

        if (!$this->isEditing) {
            $this->updateCommentform->resetValidation();
            $this->updateCommentform->reset();
        } else {
            $this->updateCommentform->message = $this->comment->message;
        }
    }

    public function isReplyingState(bool $replyingState)
    {
        $this->isReplying = $replyingState;

        if (!$this->isReplying) {
            $this->replyForm->resetValidation();
            $this->replyForm->reset();
        }
    }
}
