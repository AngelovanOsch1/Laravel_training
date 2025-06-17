<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reaction;
use Livewire\Attributes\On;
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
        return view('livewire.comment');
    }

    public function editComment(int $id)
    {
        $comment = CommentModel::findOrFail($id);
        $this->form->message = $comment->message;

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

    public function updateComment(int $id)
    {
        $this->form->validate();

        $comment = CommentModel::find($id);

        if ($this->form->photo) {
            $path = $this->uploadPhoto($this->form->photo, 'commentsPhotos');
            $this->deletePhoto($comment->photo);
        }

        $comment->update([
            'message' => $this->form->message,
            'photo' => $path ?? $comment->photo,
            'is_edited' => true
        ]);

        $this->isEditingState(false);
        $this->comment = $comment;
    }

    public function openDeleteCommentModal(int $id)
    {
        $data = [
            'body' => 'Are you sure you want to delete this comment?',
            'callBackFunction' => 'deleteComment',
            'callBackFunctionParameter' => $id
        ];
        $this->dispatch('openWarningModal', $data);
    }

    #[On('deleteComment')]
    public function deleteComment(int $id)
    {
        CommentModel::destroy($id);
        $this->dispatch('refreshComments')->to('comments');
    }

    public function like(int $id)
    {
        $this->toggleReaction($id, Reaction::TYPE_LIKE);
    }

    public function dislike(int $id)
    {
        $this->toggleReaction($id, Reaction::TYPE_DISLIKE);
    }

    protected function toggleReaction(int $id, string $type)
    {
        $existingReaction = Reaction::where('user_id', $this->loggedInUser->id)
            ->where('reactionable_id', $id)
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
                'reactionable_id' => $id,
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

    public function getComment(int $id)
    {
        return CommentModel::withCount([
            'reactions as likes_count' => fn($q) => $q->where('type', 'like'),
            'reactions as dislikes_count' => fn($q) => $q->where('type', 'dislike'),
        ])->find($id);
    }
}
