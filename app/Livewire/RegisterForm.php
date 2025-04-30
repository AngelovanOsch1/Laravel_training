<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\RegisterFormValidation;
use Illuminate\Support\Facades\Hash;
use App\Models\Authentication;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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

        $user = User::create([
            'first_name' => $this->form->firstName,
            'last_name' => $this->form->lastName,
            'country' => $this->form->country,
            'date_of_birth' => $this->form->birthYear,
            'gender' => $this->form->gender,
        ]);

        Authentication::create([
            'email' => $this->form->email,
            'password' => Hash::make($this->form->password),
            'user_id' => $user->id,
        ]);

        return redirect()->route('dashboard');
    }
}
