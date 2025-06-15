<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class LoginFormValidation extends Form
{
    public string $email;
    public string $password;
    public bool $rememberMe = false;

    protected function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'rememberMe' => 'boolean',
        ];
    }
}
