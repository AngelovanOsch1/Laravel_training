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
    public ?int $activeMessageId = null;

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

    public function editMessage(int $id)
    {
        $this->activeMessageId = $id;
        $this->dispatch('editMessage', $id);
    }
}
