<?php

namespace App\Livewire;

use Livewire\Component;
use App\Support\GlobalHelper;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Forms\PhotoFormValidation;
use Illuminate\Validation\ValidationException;

class ProfileBanner extends Component
{
    use WithFileUploads;

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

            $path = Storage::disk('public')->put('banners', $this->form->photo);

            $user = GlobalHelper::getLoggedInUser();
            $user->update([
                'profile_banner' => $path,
            ]);

            $this->profileBanner = $path;
        } catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            $this->dispatch('openWarningModal', $errorMessage);
        }
    }
}
