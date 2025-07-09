<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Contact;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Support\GlobalHelper;
use Illuminate\Support\Collection;

class AddUsersToYourList extends Component
{
    public bool $show = false;
    public User $loggedInUser;
    public Collection $userList;
    public string $query = '';
    public int $amount = 20;
    public Collection $results;


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


        $query = User::where('id', '!=', $this->loggedInUser->id)
            ->whereNotIn('id', $visibleContactUserIds);

        if (isset($this->query) && strlen($this->query) >= 2) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', "%{$this->query}%")
                    ->orWhere('last_name', 'like', "%{$this->query}%");
            });
        }

        $this->results = $query->limit($this->amount)->get();

        return view('livewire.add-users-to-your-list');
    }


    public function loadMore()
    {
        $this->amount += 20;
    }

    public function addUserToContactList($id)
    {
        $contactId = Contact::addUserToContactList($id, $this->loggedInUser->id);

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
