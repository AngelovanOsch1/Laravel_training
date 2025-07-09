<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Message as MessageModel;
use Illuminate\Validation\ValidationException;
use App\Livewire\Forms\MessageEditValidationForm;

class Message extends Component
{
    public User $loggedInUser;
    public MessageModel $message;
    public MessageEditValidationForm $form;
    public bool $isEditing = false;

    public function mount(User $loggedInUser, MessageModel $message)
    {
        $this->loggedInUser = $loggedInUser;
        $this->message = $message;
    }

    public function render()
    {
        return view('livewire.message');
    }

    public function openDeleteMessageModal()
    {
        $data = [
            'body' => 'Are you sure you want to delete this message?',
            'callBackFunction' => 'deleteMessage',
            'callBackFunctionParameter' => $this->message->id
        ];
        $this->dispatch('openWarningModal', $data);
    }

    public function isEditingState()
    {
        $this->form->message = $this->message->body;
        $this->isEditing = true;
    }

    public function submit()
    {

        if (empty($this->form->message)) {
            $this->openDeleteMessageModal();
        } else {
            try {
                $this->form->validateOnly('message');
            } catch (ValidationException $e) {
                return $this->dispatch('openWarningModal', [
                    'body' => $e->getMessage(),
                ]);
            }

            $this->message->update([
                'sender_id' => $this->loggedInUser->id,
                'body' => $this->form->message,
                'photo' => $path ?? null
            ]);

            $this->dispatch('message-updated');
            $this->isEditing = false;
            $this->form->reset();
            $this->form->resetValidation();
        }
    }
}
