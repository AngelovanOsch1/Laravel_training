<?php

namespace App\Livewire;

use Livewire\Component;
use App\Support\GlobalHelper;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Forms\PhotoFormValidation;
use Illuminate\Validation\ValidationException;

class ProfilePhoto extends Component
{
    use WithFileUploads;

    public PhotoFormValidation $form;
    public $profilePhoto;

    public function mount($profilePhoto)
    {
        $this->profilePhoto = $profilePhoto ?? 'images/default_profile_photo.png';
    }

    public function render()
    {
        return view('livewire.profile-photo');
    }

    public function updatedForm()
    {
        try {
            $this->validate();

            $path = Storage::disk('public')->put('photos', $this->form->photo);

            $user = GlobalHelper::getLoggedInUser();
            $user->update([
                'profile_photo' => $path,
            ]);

            $this->profilePhoto = $path;
        } catch (ValidationException $e) {
            $this->dispatch('openWarningModal', $e->getMessage());
        }
    }
}
