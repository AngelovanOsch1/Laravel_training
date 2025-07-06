<?php

namespace App\Livewire;

use App\Models\User;
use App\Support\GlobalHelper;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Chat extends Component
{
    public User $loggedInUser;

    public function mount()
    {
        $this->loggedInUser = GlobalHelper::getLoggedInUser();
    }
    public function render()
    {
        return view('livewire.chat');
    }
}
