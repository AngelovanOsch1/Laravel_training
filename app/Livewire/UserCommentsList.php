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
use App\Livewire\Forms\CommentFormValidation;
use Illuminate\Validation\ValidationException;

class UserCommentsList extends Component
{
    use WithPagination;
    use WithFileUploads;

    public CommentFormValidation $form;
    public CommentFormValidation $editForm;
    public User $user;

    private string $sortBy = 'created_at';

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
            ->orderBy($this->sortBy, 'desc')
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

    // public function editCommentTest(int $id)
    // {
    //     $comment = Comment::findOrFail($id);
    //     $this->editForm->message = $comment->message;
    // }

    // public function cancelEditCommentTest()
    // {
    //     $this->editForm->reset();
    //     $this->editForm->resetValidation();
    // }

    public function updateComment(int $id)
    {
        $this->editForm->validate();

        $comment = Comment::findOrFail($id);

        if ($this->editForm->photo) {
            $path = Storage::disk('public')->put('commentsPhotos', $this->editForm->photo);
        }

        $comment->update([
            'message' => $this->editForm->message,
            'photo' => $path ?? $comment->photo,
            'is_edited' => true
        ]);

        $this->editForm->photo = null;
        $this->editForm->message = '';

        $this->resetPage();
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



    public function updated($property)
    {
        if ($property === 'form.sortBy') {
            $this->sortBy = $this->form->sortBy;
        }

        if ($property === 'form.photo') {
            try {
                $this->form->validateOnly('photo');
            } catch (ValidationException $e) {
                $this->form->reset('photo');
                $this->dispatch('openWarningModal', [
                    'body' => $e->getMessage(),
                ]);
            }
        }

        if ($property === 'editForm.photo') {
            try {
                $this->editForm->validateOnly('photo');
            } catch (ValidationException $e) {
                $this->editForm->reset('photo');
                $this->dispatch('openWarningModal', [
                    'body' => $e->getMessage(),
                ]);
            }
        }
    }

    public function submit()
    {
        $this->form->validate();

        if ($this->form->photo) {
            $path = Storage::disk('public')->put('commentsPhotos', $this->form->photo);
        }

        Comment::create([
            'message' => $this->form->message,
            'commentable_id' => $this->user->id,
            'commentable_type' => User::class,
            'photo' => $path ?? null,
            'user_id' => GlobalHelper::getLoggedInUser()->id,
        ]);

        $this->form->reset();
        $this->form->resetValidation();

        $this->resetPage();
    }
}
