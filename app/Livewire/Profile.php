<?php

namespace App\Livewire;

use App\Support\GlobalHelper;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.app')]
class Profile extends Component
{
    public $user;

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
