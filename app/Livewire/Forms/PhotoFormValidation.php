<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PhotoFormValidation extends Form
{
    public ?TemporaryUploadedFile $photo = null;

    protected function rules()
    {
        return [
            'photo' => 'max:10240|mimes:jpeg,png,webp,jpg',
        ];
    }

    protected function messages()
    {
        return [
            'photo.mimes' => 'Unsupported file format. Only JPEG, PNG, WEBP and JPG formats are supported.',
            'photo.max' => 'The file size is too large. Maximum size is 10MB.',
        ];
    }
}
