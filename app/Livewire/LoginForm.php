<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\LoginFormValidation;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class LoginForm extends Component
{
    public LoginFormValidation $form;

    public function render()
    {
        return view('livewire.login-form');
    }

    public function submit()
    {
        $this->form->validate();

        if (!Auth::attempt([
            'email' => $this->form->email,
            'password' => $this->form->password,
        ])) {
            return $this->form->addError('email', 'Incorrect credentials');
        }

        session()->regenerate();
        return redirect()->route('dashboard');
    }
}
