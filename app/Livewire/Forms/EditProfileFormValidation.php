<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class EditProfileFormValidation extends Form
{
    public $firstName = '';
    public $lastName = '';
    public $country = '';
    public $gender = '';
    public $birthYear = '';
    public $description = '';

    protected function rules()
    {
        return [
            'firstName' => 'required',
            'lastName' => 'required',
            'country' => 'required',
            'gender' => 'required',
            'birthYear' => 'required',
            'description' => 'max:100',
        ];
    }
}
