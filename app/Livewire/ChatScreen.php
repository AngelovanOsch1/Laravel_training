<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Contact;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;

class ChatScreen extends Component
{
    public User $loggedInUser;
    public ?Contact $contact = null;
    public Collection $messages;

    public function mount(User $loggedInUser, ?int $latestContactId)
    {
        $this->loggedInUser = $loggedInUser;

        if ($latestContactId) {
            $this->loadChat($latestContactId);
        }
    }
    public function render()
    {
        return view('livewire.chat-screen');
    }

    #[On('loadChat')]
    public function loadChat(?int $id)
    {
        if ($id === null) {
            return $this->messages = collect();
        }

        $this->contact = Contact::with('userOne', 'userTwo', 'messages.sender')->findOrFail($id);
        $this->messages = $this->contact->messages;
    }
}
