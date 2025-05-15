<?php

namespace App\Livewire;

use Livewire\Component;
use App\Support\GlobalHelper;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Forms\PhotoFormValidation;

class ProfileBanner extends Component
{
    use WithFileUploads;

    public PhotoFormValidation $form;
    public $profileBanner;

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
        $this->handleFormUpdate();
    }

    public function handleFormUpdate()
    {
        $errorMessage = $this->form->submit();

        if (!$errorMessage) {
            $path = Storage::disk('public')->put('banners', $this->form->photo);

            $user = GlobalHelper::getLoggedInUser();
            $user->update([
                'profile_banner' => $path,
            ]);

            return redirect()->route('profile');
        } else {
            $this->dispatch('openWarningModal', $errorMessage);
        }
    }
}
