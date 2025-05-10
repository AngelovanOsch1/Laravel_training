<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class LoginFormValidation extends Form
{
    public $email = 'angelo.van.osch@hotmail.com';
    public $password = 'wachtwoord123';

    protected function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }
}
