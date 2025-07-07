<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Contact;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;

class ContactList extends Component
{
    public User $loggedInUser;
    public ?Collection $contacts = null;
    public ?int $activeContactId = null;

    public function mount(User $loggedInUser, ?int $activeContactId)
    {
        $this->loggedInUser = $loggedInUser;
        $this->activeContactId = $activeContactId;
        $this->contacts = Contact::getContactList($this->loggedInUser);
    }

    public function render()
    {
        return view('livewire.contact-list');
    }

    public function toggleVisibility(int $id)
    {
        $contact = $this->contacts->firstWhere('id', $id);

        if ($contact->user_one_id === $this->loggedInUser->id) {
            $contact->user_one_visible = false;
        } elseif ($contact->user_two_id === $this->loggedInUser->id) {
            $contact->user_two_visible = false;
        }

        if ($id === $this->activeContactId) {
            $this->dispatch('loadChat', null);
            $this->activeContactId = null;
        }

        $contact->save();
        $this->contacts = Contact::getContactList($this->loggedInUser);
    }

    public function openChat($id)
    {
        $this->activeContactId = $id;
        $this->dispatch('loadChat', $id);
    }

    #[On('chatOpen')]
    public function loadChat($id)
    {
        $this->activeContactId = $id;
        $this->contacts = Contact::getContactList($this->loggedInUser);
        $this->dispatch('loadChat', $id);
    }

    public function openAddUsersToYourListModal()
    {
        $this->dispatch('openAddUsersToYourListModal');
    }
}
