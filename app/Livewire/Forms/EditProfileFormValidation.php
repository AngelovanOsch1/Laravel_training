<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class EditProfileFormValidation extends Form
{
    public string $firstName;
    public string $lastName;
    public string $country;
    public string $gender;
    public string $date_of_birth;
    public string $description;

    protected function rules()
    {
        return [
            'firstName' => 'required',
            'lastName' => 'required',
            'country' => 'required|exists:countries,id',
            'gender' => 'required|exists:genders,id',
            'date_of_birth' => 'required|date',
            'description' => 'max:100',
        ];
    }
}
