<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class MessageEditValidationForm extends Form
{
    public string $message;

    protected function rules()
    {
        return [
            'message' => 'max:500',
        ];
    }
}
