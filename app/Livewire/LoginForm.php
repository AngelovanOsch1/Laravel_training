<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Layout('layouts.app')]
class LoginForm extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public function render()
    {
        return view('livewire.login-form');
    }

    public function submit()
    {
        $this->validate();

        if ($this->LoginService->login($this->email, $this->password)) {
            return redirect()->route('dashboard');
        }

        $this->addError('email', 'Invalid credentials.');
    }
}
