<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CommentFormValidation extends Form
{
    public string $message = '';

    protected function rules()
    {
        return [
            'message' => 'required|max:300',
        ];
    }
}
