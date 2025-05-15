<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class LoginFormValidation extends Form
{
    public $email = '';
    public $password = '';

    protected function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }
}
