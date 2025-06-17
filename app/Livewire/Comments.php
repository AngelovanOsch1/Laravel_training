<?php

namespace App\Livewire;

use App\Models\User;
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
    public User $user;
    public User $loggedInUser;

    private string $sortBy = 'created_at';

    public function mount($id)
    {
        $this->user = User::findOrFail($id);
        $this->loggedInUser = GlobalHelper::getLoggedInUser();
    }

    #[On('refreshComments')]
    public function render()
    {
        $commentsList = $this->user->comments()
            ->with('user')
            ->with([
                'reactions' => fn($q) => $q->where('user_id', $this->loggedInUser->id),
            ])
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

        return view('livewire.comments', [
            'commentsList' => $commentsList,
        ]);
    }

    public function updatedForm($property, $value)
    {
        if ($value === 'photo') {
            try {
                $this->form->validateOnly('photo');
            } catch (ValidationException $e) {
                $this->form->reset('photo');
                $this->dispatch('openWarningModal', [
                    'body' => $e->getMessage(),
                ]);
            }
            return;
        }

        if ($value === 'sortBy') {
            $this->sortBy = $this->form->sortBy;
            $this->resetPage();
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
