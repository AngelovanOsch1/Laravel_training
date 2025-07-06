<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class ChatList extends Component
{
    public User $loggedInUser;

    public function mount(User $loggedInUser)
    {
        $this->loggedInUser = $loggedInUser;
    }

    public function render()
    {
        return view('livewire.chat-list');
    }

    public function openAddUsersToYourListModal()
    {
        $this->dispatch('openAddUsersToYourListModal');
    }
}
