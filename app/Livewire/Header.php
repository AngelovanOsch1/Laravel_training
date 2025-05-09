<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
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
