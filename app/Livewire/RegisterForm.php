<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;


#[Layout('layouts.app')]
class RegisterForm extends Component
{
    public $email;
    public $password;
    public $passwordConfirm;

    public function render()
    {
        return view('livewire.register-form');
    }

    public function submit()
    {   
        $validatedData = $this->form->validated();

        $this->userService->registerUser($validatedData);

        return redirect()->route('dashboard');
    }
}