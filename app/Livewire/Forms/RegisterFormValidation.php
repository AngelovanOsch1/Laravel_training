<?php

namespace App\Livewire\Forms;

use Livewire\Form;

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
            'email' => ['required', 'email', 'unique:authentication,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'firstName' => ['required'],
            'lastName' => ['required'],
            'country' => ['required'],
            'gender' => ['required'],
            'birthYear' => ['required'],
        ];
    }
}
