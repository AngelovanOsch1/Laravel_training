<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Support\GlobalHelper;

class AddUsersToYourList extends Component
{
    public bool $show = false;
    public User $loggedInUser;

    public function mount()
    {
        $this->loggedInUser = GlobalHelper::getLoggedInUser();
    }

    public function render()
    {
        return view('livewire.add-users-to-your-list');
    }

    public function addUserToList()
    {
        dd('test');
    }

    #[On('openAddUsersToYourListModal')]
    public function openModal()
    {
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
    }
}
