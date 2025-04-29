<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\RegisterFormValidation;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

#[Layout('layouts.app')]
class RegisterForm extends Component
{
    public RegisterFormValidation $form;

    public function render()
    {
        return view('livewire.register-form');
    }

    public function submit()
    {   
        $this->form->validate();

        User::create([
            'email' => $this->form->email,
            'password' => Hash::make($this->form->password),
        ]);
        
        return redirect()->route('dashboard');
    }
}
