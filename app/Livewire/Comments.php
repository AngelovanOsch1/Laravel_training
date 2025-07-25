<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Series;
use App\Models\Comment;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Support\GlobalHelper;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Forms\CommentFormValidation;
use Illuminate\Validation\ValidationException;

class Comments extends Component
{
    use WithPagination;
    use WithFileUploads;

    public CommentFormValidation $form;
    public User|Series $model;
    public User $loggedInUser;
    public string $commentType;
    private string $sortBy = 'created_at';

    public function mount(int $id, string $commentType)
    {
        $this->commentType = $commentType;
        $this->model = $this->findObject($this->commentType, $id);
        $this->loggedInUser = GlobalHelper::getLoggedInUser();
    }

    public function render()
    {
        $query = $this->model->comments()
            ->whereNull('parent_id')
            ->withCount([
                'reactions as likes_count' => fn($q) => $q->where('type', 'like'),
            ]);

        $commentsList = $query->orderBy($this->sortBy, 'desc')->paginate(5);

        return view('livewire.comments', [
            'commentsList' => $commentsList,
        ]);
    }

    public function findObject(string $commenType, int $id)
    {
        return match (true) {
            $commenType === 'App\Models\User' =>  User::findOrFail($id),
            $commenType === 'App\Models\Series' =>  Series::findOrFail($id),
        };
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

    public function updatedFormSortBy()
    {
        $this->sortBy = $this->form->sortBy;
        $this->gotoPage(1);
    }

    public function submit()
    {
        $this->form->validate();

        if ($this->form->photo) {
            $path = Storage::disk('public')->put('commentsPhotos', $this->form->photo);
        }

        Comment::create([
            'message' => $this->form->message,
            'commentable_id' => $this->model->id,
            'commentable_type' => $this->commentType,
            'photo' => $path ?? null,
            'user_id' => $this->loggedInUser->id,
        ]);

        $this->form->reset();
        $this->form->resetValidation();
        $this->gotoPage(1);
    }

    #[On('deleteComment')]
    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        $parentId = $comment->parent_id;

        $comment->delete();

        $this->dispatch("childCommentDeleted.$parentId");
        $this->gotoPage(1);
    }

    #[On('profilePhotoUpdated')]
    public function refreshProfilePhoto($newPhotoPath)
    {
        $this->loggedInUser->profilePhoto = $newPhotoPath;
    }
}
