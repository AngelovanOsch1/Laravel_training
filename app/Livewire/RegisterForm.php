<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Country;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use App\Livewire\Forms\RegisterFormValidation;

#[Layout('layouts.app')]
class RegisterForm extends Component
{
    public RegisterFormValidation $form;
    public $countries;

    public function mount()
    {
        $this->countries = Country::all();
    }

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
            'first_name' => $this->form->firstName,
            'last_name' => $this->form->lastName,
            'country_id' => $this->form->country,
            'date_of_birth' => $this->form->birthYear,
            'gender' => $this->form->gender,
        ]);

        return redirect()->route('dashboard');
    }
}
