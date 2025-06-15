<?php

namespace App\Livewire;

use Livewire\Component;
use App\Support\GlobalHelper;
use App\Traits\HandlesPhotos;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Forms\PhotoFormValidation;
use Illuminate\Validation\ValidationException;

class ProfileBanner extends Component
{
    use WithFileUploads;
    use HandlesPhotos;

    public PhotoFormValidation $form;
    public string|null $profileBanner;

    public function mount($profileBanner)
    {
        $this->profileBanner = $profileBanner ?? 'images/default_profile_banner.webp';
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

            $user = GlobalHelper::getLoggedInUser();

            $this->deletePhoto($user->profile_banner);

            $user->update([
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
