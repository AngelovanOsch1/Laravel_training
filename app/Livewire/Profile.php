<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Support\GlobalHelper;
use Livewire\Attributes\Layout;


#[Layout('layouts.app')]
class Profile extends Component
{
    public User $user;

    public function mount()
    {
        $this->user = GlobalHelper::getLoggedInUser();
    }

    public function render()
    {
        return view('livewire.profile');
    }

    public function openEditProfileModal()
    {
        $this->dispatch('openEditProfileModal', $this->user);
    }
}
