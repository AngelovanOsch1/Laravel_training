<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CommentFormValidation extends Form
{
    public ?string $message = null;
    public ?TemporaryUploadedFile $photo = null;
    public string $sortBy = 'created_at';

    protected function rules()
    {
        return [
            'message' => 'max:300|nullable|required_without:photo',
            'photo' => 'max:10240|mimes:jpeg,png,webp,jpg|nullable',
            'sortBy' => 'in:created_at,likes_count|nullable',
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
