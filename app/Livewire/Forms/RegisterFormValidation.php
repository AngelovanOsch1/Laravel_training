<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class RegisterFormValidation extends Form
{
    public string $email;
    public string $password;
    public string $password_confirmation;
    public string $firstName;
    public string $lastName;
    public string $country;
    public string $date_of_birth;
    public string $gender;

    protected function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'firstName' => 'required',
            'lastName' => 'required',
            'country' => 'required|exists:countries,id',
            'gender' => 'required|exists:genders,id',
            'date_of_birth' => 'required|date',
        ];
    }
}
