<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class ContactUsForm extends Form
{
    public $name;
    public $email;
    public $message;

    protected function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required|max:500'
        ];
    }
}
