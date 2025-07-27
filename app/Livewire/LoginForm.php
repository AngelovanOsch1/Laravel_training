<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\LoginFormValidation;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class LoginForm extends Component
{
    public LoginFormValidation $form;

    public function mount()
    {
        if (Auth::check()) {
            return redirect()->route('profile', Auth::id());
        }
    }

    public function render()
    {
        return view('livewire.login-form');
    }

    public function submit()
    {
        $this->form->validate();

        $user = User::where('email', $this->form->email)->first();

        if ($user && $user->is_blocked) {
            return $this->form->addError('email', 'Your account has been blocked.');
        }

        if (!Auth::attempt([
            'email' => $this->form->email,
            'password' => $this->form->password,
        ], $this->form->rememberMe)) {
            return $this->form->addError('email', 'Incorrect credentials');
        }

        session()->regenerate();

        return redirect()->route('profile', ['id' => Auth::user()->id]);
    }
}
