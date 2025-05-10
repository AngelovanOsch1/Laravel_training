<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
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
