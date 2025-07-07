<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Traits\HandlesPhotos;
use Livewire\WithFileUploads;
use App\Livewire\Forms\PhotoFormValidation;
use Illuminate\Validation\ValidationException;

class ProfileBanner extends Component
{
    use WithFileUploads;
    use HandlesPhotos;

    public PhotoFormValidation $form;
    public string|null $profileBanner;
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
        $this->profileBanner = $this->user->profile_banner ?? 'images/default_profile_banner.webp';
    }

    public function render()
    {
        return view('livewire.profile-banner');
    }

    public function updatedForm()
    {
        try {
            $this->validate();

            $path = $this->uploadPhoto($this->form->photo, 'banners');

            $this->deletePhoto($this->user->profile_banner);

            $this->user->update([
                'profile_banner' => $path,
            ]);

            $this->profileBanner = $path;
        } catch (ValidationException $e) {
            $errorMessage = [
                'body' => $e->getMessage(),
            ];

            $this->dispatch('openWarningModal', $errorMessage);
        }
    }
}
