<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Reaction;
use App\Support\GlobalHelper;
use Livewire\Attributes\Layout;


#[Layout('layouts.app')]
class Profile extends Component
{
    public User $user;
    public User $LoggedInUser;
    public object $likesObject;

    public function mount($id = null)
    {
        $this->user = $id ? User::findOrFail($id) : GlobalHelper::getLoggedInUser();
        $this->LoggedInUser = GlobalHelper::getLoggedInUser();
    }

    public function render()
    {
        $reactionCollections = $this->user->reactions;
        $hasAlreadyLiked = $this->user->reactions->contains('user_id', $this->LoggedInUser->id);

        $likeCount = $reactionCollections->count();

        $this->likesObject = (object) [
            'hasalreadyLiked' => $hasAlreadyLiked,
            'likeCount' => $likeCount,
        ];

        return view('livewire.profile');
    }

    public function likeUser($id)
    {
        if (!$this->LoggedInUser) {
            return redirect()->route('login');
        }

        $existingReaction = Reaction::where('user_id', $this->LoggedInUser->id)
            ->where('reactionable_id', $id)
            ->where('reactionable_type', User::class)
            ->first();

        if ($existingReaction) {
            if ($existingReaction->type === Reaction::TYPE_LIKE) {
                $existingReaction->delete();
            } else {
                $existingReaction->type = Reaction::TYPE_LIKE;
                $existingReaction->save();
            }
        } else {
            Reaction::create([
                'user_id' => $this->LoggedInUser->id,
                'reactionable_id' => $id,
                'reactionable_type' => User::class,
                'type' => Reaction::TYPE_LIKE,
            ]);
        }
    }

    public function openEditProfileModal()
    {
        $this->dispatch('openEditProfileModal', $this->user);
    }
}
