<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Contact;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
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

    public function mount(User $loggedInUser, ?int $latestContactId)
    {
        $this->loggedInUser = $loggedInUser;

        if ($latestContactId) {
            $this->contactId = $latestContactId;
            $this->loadChat($latestContactId);
        }
    }

    public function render()
    {
        return view('livewire.chat-screen');
    }

    #[On("echo:private-chat.{contactId},.MessageCreated")]
    public function refresh()
    {
        $this->loadChat($this->contactId);
    }

    #[On('incomingMessage')]
    public function incomingMessage($message)
    {
        dd($message);
        $this->messages->push(new \App\Models\Message((array) $message));
    }

    #[On('loadChat')]
    public function loadChat(?int $id)
    {
        if ($id === null) {
            return $this->messages = null;
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
            $this->activeMessageId = null;
        } else {
            $message = Message::create([
                'contact_id' => $this->contact->id,
                'sender_id' => $this->loggedInUser->id,
                'body' => $this->form->message,
                'photo' => $path ?? null
            ]);

            Log::info('MessageSent event fired');

            // broadcast(new MessageSent($message))->toOthers();

            Log::info('MessageSent event broadcasted');
            $this->messages->push($message);
        }

        $this->contact->update([
            'user_one_visible' => true,
            'user_two_visible' => true,
        ]);

        $this->dispatch('message-updated');
        $this->dispatch('refreshContactList');

        $this->isEditing = false;
        $this->form->reset();
        $this->form->resetValidation();
    }

    public function editMessage($id)
    {
        $this->isEditing = true;
        $this->activeMessageId = $id;

        $this->message = $this->messages->find($id);

        $this->form->message = $this->message->body;
        $this->form->photo = $this->message->photo;
    }

    public function openDeleteMessageModal($id)
    {
        $data = [
            'body' => 'Are you sure you want to delete this message?',
            'callBackFunction' => 'deleteMessage',
            'callBackFunctionParameter' => $id
        ];
        $this->dispatch('openWarningModal', $data);
    }

    #[On('deleteMessage')]
    public function deleteMessage($id)
    {
        Message::destroy($id);

        $this->messages = $this->contact->messages()->with('sender')->get();
    }
}
