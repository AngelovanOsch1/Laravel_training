<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Contact;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;
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
    public Collection $messages;
    public Message $message;
    public MessageValidationForm $form;
    public bool $isEditing = false;

    public function mount(User $loggedInUser, ?int $latestContactId)
    {
        $this->loggedInUser = $loggedInUser;

        if ($latestContactId) {
            $this->loadChat($latestContactId);
        }
    }
    public function render()
    {
        $this->dispatch('chat-opened');

        return view('livewire.chat-screen');
    }

    #[On('loadChat')]
    public function loadChat(?int $id)
    {
        if ($id === null) {
            return;
        }

        $this->contact = Contact::with('userOne', 'userTwo', 'messages.sender')->findOrFail($id);

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
        try {
            $this->form->validateOnly('message');
        } catch (ValidationException $e) {
            return $this->dispatch('openWarningModal', [
                'body' => $e->getMessage(),
            ]);
        }

        if ($this->form->photo) {
            $path = Storage::disk('public')->put('messagesPhotos', $this->form->photo);
        }

        if ($this->isEditing) {
            $this->message->update([
                'body' => $this->form->message,
                'photo' => $path ?? null
            ]);
        } else {
            Message::create([
                'contact_id' => $this->contact->id,
                'sender_id' => $this->loggedInUser->id,
                'body' => $this->form->message,
                'photo' => $path ?? null
            ]);
        }

        $this->messages = $this->contact->messages()->with('sender')->get();
        $this->dispatch('chat-scroll-down');
        $this->dispatch('message-updated');
        $this->dispatch('refreshContactList');

        $this->isEditing = false;
        $this->form->reset();
        $this->form->resetValidation();
    }

    #[On('editMessage')]
    public function editMessage($id)
    {
        $this->isEditing = true;
        $this->message = $this->messages->find($id);

        $this->form->message = $this->message->body;
        $this->form->photo = $this->message->photo;
    }

    #[On('deleteMessage')]
    public function deleteMessage($id)
    {
        Message::destroy($id);

        $this->messages = $this->contact->messages()->with('sender')->get();
    }
}
