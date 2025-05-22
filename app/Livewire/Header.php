<?php

namespace App\Livewire;

use Livewire\Component;
use App\Support\GlobalHelper;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    public string $profilePhoto;
    protected $listeners = ['profilePhotoUpdated' => 'refreshProfilePhoto'];

    public function mount()
    {
        $user = GlobalHelper::getLoggedInUser()->fresh();
        $this->profilePhoto = $user->profile_photo ?? 'images/default_profile_photo.png';
    }

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
        return redirect()->route('dashboard');
    }
}
