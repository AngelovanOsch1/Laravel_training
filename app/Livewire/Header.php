<?php

namespace App\Livewire;

use Livewire\Component;
use App\Support\GlobalHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    public $profilePhoto;

    public function mount()
    {
        $user = GlobalHelper::getLoggedInUser();
        $this->profilePhoto = $user->profile_photo ?? 'images/default_profile_photo.png';
    }

    public function render()
    {
        return view('livewire.header');
    }


    public function logout()
    {
        Log::info('Livewire is working! Something random');

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('dashboard');
    }
}
