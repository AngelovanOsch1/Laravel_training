<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Illuminate\Validation\ValidationException;
use App\ErrorMessages\ErrorMessages;

class PhotoFormValidation extends Form
{
    public $photo;

    protected function rules()
    {
        return [
            'photo' => 'max:10240|mimes:jpeg,png,webp,jpg',
        ];
    }

    public function submit()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $failedRules = $e->validator->failed();
            $failedKey = array_keys($failedRules['form.photo']);
            return ErrorMessages::getErrorMessage($failedKey);
        }
    }
}
