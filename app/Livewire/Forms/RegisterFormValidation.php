<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Illuminate\Validation\Rules\Password;

class RegisterFormValidation extends Form
{
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $firstName = '';
    public $lastName = '';
    public $country = '';
    public $birthYear = '';
    public $gender = '';

    protected function rules()
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::defaults(), 'confirmed'],
            'firstName' => ['required', 'string', 'max:50'],
            'lastName' => ['required', 'string', 'max:50'],
            'country' => ['required', 'string', 'max:50'],
            'gender' => ['required'],
            'birthYear' => ['required', 'date_format:m/d/Y'],
        ];
    }
}
