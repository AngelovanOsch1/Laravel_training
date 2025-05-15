<?php

namespace App\Livewire;

use Livewire\Component;
use App\Support\GlobalHelper;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Forms\PhotoFormValidation;

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
        $this->handleFormUpdate();
    }

    public function handleFormUpdate()
    {
        $errorMessage = $this->form->submit();
        if (!$errorMessage) {
            $path = Storage::disk('public')->put('photos', $this->form->photo);

            $user = GlobalHelper::getLoggedInUser();
            $user->update([
                'profile_photo' => $path,
            ]);
            return redirect()->route('profile');
        } else {
            $this->dispatch('openWarningModal', $errorMessage);
        }
    }
}
