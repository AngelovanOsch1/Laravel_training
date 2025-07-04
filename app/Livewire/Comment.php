<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reaction;
use App\Traits\HandlesPhotos;
use Livewire\WithFileUploads;
use App\Models\Comment as CommentModel;
use App\Livewire\Forms\CommentFormValidation;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class Comment extends Component
{
    use WithFileUploads;
    use HandlesPhotos;

    public CommentFormValidation $form;
    public CommentModel $comment;
    public User $user;
    public User $loggedInUser;
    public bool $isEditing = false;

    public function mount(CommentModel $comment, User $user, User $loggedInUser)
    {
        $this->comment = $comment;
        $this->user = $user;
        $this->loggedInUser = $loggedInUser;
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

    public function editComment()
    {
        $this->form->message = $this->comment->message;
        $this->isEditingState(true);
    }

    public function closeEditing()
    {
        $this->isEditingState(false);
    }

    public function updatedFormPhoto()
    {
        try {
            $this->form->validateOnly('photo');
        } catch (ValidationException $e) {
            $this->form->reset('photo');
            $this->dispatch('openWarningModal', [
                'body' => $e->getMessage(),
            ]);
        }
    }

    public function updateComment()
    {
        $this->form->validate();

        if ($this->form->photo) {
            $path = $this->uploadPhoto($this->form->photo, 'commentsPhotos');
            $this->deletePhoto($this->comment->photo);
        }

        $this->comment->update([
            'message' => $this->form->message,
            'photo' => $path ?? $this->comment->photo,
            'is_edited' => true
        ]);

        $this->isEditingState(false);
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

    public function like()
    {
        $this->toggleReaction(Reaction::TYPE_LIKE);
    }

    public function dislike()
    {
        $this->toggleReaction(Reaction::TYPE_DISLIKE);
    }

    protected function toggleReaction(string $type)
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

    public function isEditingState(bool $editState)
    {
        $this->isEditing = $editState;

        if (!$this->isEditing) {
            $this->resetValidation();
            $this->form->reset();
        }
    }
}
