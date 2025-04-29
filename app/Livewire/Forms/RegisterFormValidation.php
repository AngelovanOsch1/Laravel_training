<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Illuminate\Validation\Rules\Password;

class RegisterFormValidation extends Form
{
    public $email = '';
    public $password = '';
    public $password_confirmation;

    protected function rules()
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ];
    }
}
