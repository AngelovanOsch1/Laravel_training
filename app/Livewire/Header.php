<?php

namespace App\Livewire;

use App\Livewire\Forms\LocalizationForm;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Support\GlobalHelper;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Header extends Component
{
    public string|null $profilePhoto;
    public LocalizationForm $form;

    public function mount()
    {
        $user = GlobalHelper::getLoggedInUser();
        $this->profilePhoto = $user->profile_photo ?? 'images/default_profile_photo.png';

        $this->form->selectedLanguage = Session::get('locale', config('app.locale'));
        App::setLocale($this->form->selectedLanguage);
    }

    public function updatedFormSelectedLanguage($value)
    {
        $this->form->selectedLanguage = $value;
        Session::put('locale', $this->form->selectedLanguage);
        App::setLocale($this->form->selectedLanguage);
    }


    #[On('profilePhotoUpdated')]
    public function refreshProfilePhoto($newPhotoPath)
    {
        $this->profilePhoto = $newPhotoPath;
    }

    public function render()
    {
        return view('livewire.header');
    }


    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
