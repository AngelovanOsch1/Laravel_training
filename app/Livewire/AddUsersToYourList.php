<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Contact;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Support\GlobalHelper;
use Illuminate\Support\Collection;

class AddUsersToYourList extends Component
{
    public bool $show = false;
    public User $loggedInUser;
    public Collection $userList;

    public function mount()
    {
        $this->loggedInUser = GlobalHelper::getLoggedInUser();
    }

    public function render()
    {
        $visibleContactUserIds = Contact::where(function ($query) {
            $query->where('user_one_id', $this->loggedInUser->id)
                ->where('user_one_visible', true);
        })->orWhere(function ($query) {
            $query->where('user_two_id', $this->loggedInUser->id)
                ->where('user_two_visible', true);
        })->get()->map(function ($contact) {
            return $contact->user_one_id === $this->loggedInUser->id
                ? $contact->user_two_id
                : $contact->user_one_id;
        })->toArray();

        $this->userList = User::where('id', '!=', $this->loggedInUser->id)
            ->whereNotIn('id', $visibleContactUserIds)
            ->get();

        return view('livewire.add-users-to-your-list');
    }

    public function addUserToList($id)
    {
        $userOne = min($this->loggedInUser->id, $id);
        $userTwo = max($this->loggedInUser->id, $id);

        $existingContact = Contact::where('user_one_id', $userOne)
            ->where('user_two_id', $userTwo)
            ->first();

        if ($existingContact) {
            if ($existingContact->user_one_id === $this->loggedInUser->id) {
                $existingContact->user_one_visible = true;
            } else {
                $existingContact->user_two_visible = true;
            }

            $existingContact->save();
            $contactId = $existingContact->id;
        } else {
            $contact = Contact::create([
                'user_one_id' => $userOne,
                'user_two_id' => $userTwo,
                'added_by_user_id' => $this->loggedInUser->id,
                'user_one_visible' => $userOne === $this->loggedInUser->id,
                'user_two_visible' => $userTwo === $this->loggedInUser->id ? false : true,
            ]);

            Message::create([
                'contact_id' => $contact->id,
                'sender_id' => $this->loggedInUser->id,
                'body' => 'Chat started',
            ]);

            $contactId = $contact->id;
        }

        $this->dispatch('chatOpen', $contactId);
        $this->closeModal();
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
