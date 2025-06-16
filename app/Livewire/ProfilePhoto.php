<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Support\GlobalHelper;
use App\Traits\HandlesPhotos;
use Livewire\WithFileUploads;
use App\Livewire\Forms\PhotoFormValidation;
use Illuminate\Validation\ValidationException;

class ProfilePhoto extends Component
{
    use WithFileUploads;
    use HandlesPhotos;

    public PhotoFormValidation $form;
    public User $user;
    public string|null $profilePhoto;

    public function mount($user)
    {
        $this->user = $user;
        $this->profilePhoto = $user->profile_photo ?? 'images/default_profile_photo.png';
    }

    public function render()
    {
        return view('livewire.profile-photo');
    }

    public function updatedForm()
    {
        try {
            $this->validate();

            $path = $this->uploadPhoto($this->form->photo);

            $user = GlobalHelper::getLoggedInUser();

            $this->deletePhoto($user->profile_photo);

            $user->update([
                'profile_photo' => $path,
            ]);

            $this->profilePhoto = $path;
            $this->dispatch('profilePhotoUpdated', $this->profilePhoto);
        } catch (ValidationException $e) {
            $errorMessage = [
                'body' => $e->getMessage(),
            ];

            $this->dispatch('openWarningModal', $errorMessage);
        }
    }
}
