<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Contact;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Events\MessageCreate;
use App\Events\MessageDelete;
use App\Events\MessageUpdate;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Forms\MessageValidationForm;
use Illuminate\Validation\ValidationException;

class ChatScreen extends Component
{
    use WithFileUploads;

    public User $loggedInUser;
    public ?Contact $contact = null;
    public ?Collection $messages = null;
    public Message $message;
    public MessageValidationForm $form;
    public bool $isEditing = false;
    public ?int $activeMessageId = null;
    public int $contactId;
    public int $userId;
    public int $receiverId;

    public function mount(User $loggedInUser, ?int $latestContactId)
    {
        $this->loggedInUser = $loggedInUser;

        if ($latestContactId) {
            $this->contactId = $latestContactId;
            $this->loadChat($latestContactId);
            $this->receiverId = $this->getReceiverId();
        }
    }

    public function render()
    {
        return view('livewire.chat-screen');
    }

    #[On('echo:private-chat.{loggedInUser.id},.message.create')]
    public function refresh($payload)
    {
        $id = $payload['messageId'];
        $message = Message::with('sender')->find($id);

        if ($message->contact_id === $this->contactId) {
            $this->messages->push($message);
        }
        $this->refreshContactList();
    }

    #[On('echo:private-chat.{loggedInUser.id},.message.update')]
    public function refreshUpdate($payload)
    {
        $id = $payload['messageId'];
        $message = Message::with('sender')->find($id);

        if ($message->contact_id === $this->contactId) {
            $index = $this->messages->search(fn($message) => $message->id === $message->id);
            $this->messages[$index] = $message;
        }
        $this->refreshContactList();
    }

    #[On('echo:private-chat.{loggedInUser.id},.message.delete')]
    public function refreshDelete($payload)
    {
        $id = $payload['messageId'];
        $message = $this->messages->first(fn($message) => $message->id === $id);

        if ($message && $message->contact_id === $this->contactId) {
            $this->messages = $this->messages->filter(fn($m) => $m->id !== $id)->values();
        }
        $this->refreshContactList();
    }

    #[On('loadChat')]
    public function loadChat(?int $id)
    {
        if ($id === null) {
            return $this->messages = null;
        }

        $this->contactId = $id;

        $this->contact = Contact::with('userOne', 'userTwo', 'messages.sender')->findOrFail($this->contactId);

        Message::where('contact_id', $this->contact->id)
            ->where('sender_id', '!=', $this->loggedInUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->messages = $this->contact->messages;
    }

    public function updatedFormPhoto()
    {
        try {
            $this->form->validateOnly('photo');
        } catch (ValidationException $e) {
            $this->form->reset('photo');
            $this->dispatch('openWarningModal', [
                'body' => $e->getMessage(),
            ]);
        }
    }

    public function submit()
    {
        if ($this->isEditing && $this->form->message === $this->message->body && $this->form->photo === $this->message->photo) {
            $this->isEditing = false;
            $this->form->reset();
            $this->form->resetValidation();
            $this->activeMessageId = null;
            return;
        }

        if (!$this->isEditing) {
            try {
                $this->form->validateOnly('message');
            } catch (ValidationException $e) {
                return $this->dispatch('openWarningModal', [
                    'body' => $e->getMessage(),
                ]);
            }
        }

        $path = null;
        if ($this->form->photo) {
            $path = Storage::disk('public')->put('messagesPhotos', $this->form->photo);
        }

        if ($this->isEditing) {
            $indexMessage = $this->messages->search(fn($message) => $message->id === $this->message->id);

            if (empty($this->form->message) && empty($this->form->photo)) {
                $this->openDeleteMessageModal($this->message->id);
            } else {
                $this->message->update([
                    'body' => $this->form->message,
                    'photo' => $path,
                ]);

                $this->messages[$indexMessage] = $this->message;
                broadcast(new MessageUpdate($this->message->id, $this->receiverId))->toOthers();
            }

            $this->activeMessageId = null;
        } else {
            $message = Message::create([
                'contact_id' => $this->contact->id,
                'sender_id' => $this->loggedInUser->id,
                'body' => $this->form->message,
                'photo' => $path,
            ]);

            broadcast(new MessageCreate($message->id, $this->receiverId))->toOthers();
            $this->messages->push($message);
        }

        $this->contact->update([
            $this->contact->user_one_id === $this->receiverId
                ? 'user_one_visible'
                : 'user_two_visible' => true,
        ]);

        $this->dispatch('message-updated');
        $this->refreshContactList();
        $this->isEditing = false;
        $this->form->reset();
        $this->form->resetValidation();
    }

    public function editMessage(int $id)
    {
        $this->isEditing = true;
        $this->activeMessageId = $id;

        $this->message = $this->messages->find($id);

        $this->form->message = $this->message->body;
        $this->form->photo = $this->message->photo;
    }

    public function openDeleteMessageModal(int $id)
    {
        $data = [
            'body' => 'Are you sure you want to delete this message?',
            'callBackFunction' => 'deleteMessage',
            'callBackFunctionParameter' => $id
        ];
        $this->dispatch('openWarningModal', $data);
    }

    public function refreshContactList()
    {
        $this->dispatch('refreshContactList');
    }

    public function getReceiverId()
    {
        return $this->contact->user_one_id === $this->loggedInUser->id
            ? $this->contact->user_two_id
            : $this->contact->user_one_id;
    }

    #[On('deleteMessage')]
    public function deleteMessage(int $id)
    {
        Message::destroy($id);
        $this->messages = $this->contact->messages()->with('sender')->get();

        broadcast(new MessageDelete($id, $this->receiverId))->toOthers();
    }
}
