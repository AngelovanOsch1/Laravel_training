<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Gender;
use App\Models\Country;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Livewire\Forms\RegisterFormValidation;

#[Layout('layouts.app')]
class RegisterForm extends Component
{
    public RegisterFormValidation $form;
    public Collection $countries;
    public Collection $genders;

    public function mount()
    {
        $this->countries = Country::all();
        $this->genders = Gender::all();
    }

    public function render()
    {
        return view('livewire.register-form');
    }

    public function submit()
    {
        $this->form->validate();

        $user = User::create([
            'email' => $this->form->email,
            'password' => Hash::make($this->form->password),
            'first_name' => $this->form->firstName,
            'last_name' => $this->form->lastName,
            'country_id' => $this->form->country,
            'date_of_birth' => $this->form->date_of_birth,
            'gender_id' => $this->form->gender,
        ]);

        Auth::login($user);
        return redirect()->route('profile', ['id' => $user->id]);
    }
}
