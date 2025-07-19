<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class LocalizationForm extends Form
{
    public string $selectedLanguage = 'en';

    protected function rules()
    {
        return [
            'selectedLanguage' => 'required',
        ];
    }
}
