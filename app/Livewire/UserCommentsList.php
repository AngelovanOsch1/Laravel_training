<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Comment;
use Livewire\Component;
use App\Models\Reaction;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Support\GlobalHelper;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Forms\PhotoFormValidation;
use App\Livewire\Forms\CommentFormValidation;
use Illuminate\Validation\ValidationException;

#[Layout('layouts.app')]
class UserCommentsList extends Component
{
    use WithPagination;
    use WithFileUploads;

    public CommentFormValidation $form;
    public PhotoFormValidation $photoForm;
    public User $user;

    public function mount($id)
    {
        $this->user = User::findOrFail($id);
    }

    public function render()
    {
        $commentsList = $this->user->comments()
            ->with('user', 'reactions')
            ->withCount([
                'reactions as likes_count' => function ($query) {
                    $query->where('type', 'like');
                },
                'reactions as dislikes_count' => function ($query) {
                    $query->where('type', 'dislike');
                },
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.user-comments-list', [
            'commentsList' => $commentsList,
        ]);
    }

    public function openDeleteCommentModal($id)
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
        Comment::destroy($id);
    }

    public function like($id)
    {
        $this->toggleReaction($id, Reaction::TYPE_LIKE);
    }

    public function dislike($id)
    {
        $this->toggleReaction($id, Reaction::TYPE_DISLIKE);
    }

    protected function toggleReaction($id, $type)
    {

        $existingReaction = Reaction::where('user_id', $this->user->id)
            ->where('reactionable_id', $id)
            ->where('reactionable_type', Comment::class)
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
                'user_id' => $this->user->id,
                'reactionable_id' => $id,
                'reactionable_type' => Comment::class,
                'type' => $type,
            ]);
        }
    }

    public function updatedphotoForm()
    {
        try {
            $this->photoForm->validate();
        } catch (ValidationException $e) {
            $this->photoForm->reset();
            $errorMessage = [
                'body' => $e->getMessage(),
            ];
            $this->dispatch('openWarningModal', $errorMessage);
        }
    }

    public function submit()
    {
        $this->form->validate();

        if ($this->photoForm->photo) {
            $path = Storage::disk('public')->put('commentsPhotos', $this->photoForm->photo);
        }

        Comment::create([
            'message' => $this->form->message,
            'commentable_id' => $this->user->id,
            'commentable_type' => User::class,
            'image' => $path ?? null,
            'user_id' => GlobalHelper::getLoggedInUser()->id,
        ]);

        $this->form->reset();
        $this->form->resetValidation();

        $this->photoForm->reset();
        $this->photoForm->resetValidation();

        $this->resetPage();
    }
}
