<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Traits\HandlesPhotos;
use Livewire\WithFileUploads;
use App\Livewire\Forms\PhotoFormValidation;
use Illuminate\Validation\ValidationException;

class ProfilePhoto extends Component
{
    use WithFileUploads;
    use HandlesPhotos;

    public PhotoFormValidation $form;
    public string|null $profilePhoto;
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
        $this->profilePhoto = $this->user->profile_photo ?? 'images/default_profile_photo.png';
    }

    public function render()
    {
        return view('livewire.profile-photo');
    }

    public function updatedForm()
    {
        try {
            $this->validate();

            $path = $this->uploadPhoto($this->form->photo, 'photos');

            $this->deletePhoto($this->user->profile_photo);

            $this->user->update([
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
