<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Forms\EditProfileFormValidation;

class EditProfile extends Component
{
    public EditProfileFormValidation $form;

    public function render()
    {
        return view('livewire.edit-profile');
    }

    public function submit()
    {
        $this->validate();

        return redirect()->route('profile');
    }
}
