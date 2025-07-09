<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Contact;
use Livewire\Component;
use App\Support\GlobalHelper;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Chat extends Component
{
    public User $loggedInUser;
    public ?int $latestContactId = null;

    public function mount(?int $id = null)
    {
        $this->loggedInUser = GlobalHelper::getLoggedInUser();

        if ($id) {
            return $this->latestContactId = $id;
        }

        $contacts = Contact::getContactList($this->loggedInUser);
        $this->latestContactId = $contacts->first()?->id;
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
