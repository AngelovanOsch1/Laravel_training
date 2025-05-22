<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Gender;
use App\Models\Country;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Support\GlobalHelper;
use Illuminate\Support\Collection;
use App\Livewire\Forms\EditProfileFormValidation;

class EditProfile extends Component
{
    public EditProfileFormValidation $form;
    public bool $show = false;

    public Collection $countries;
    public Collection $genders;

    public function mount()
    {
        $this->countries = Country::all();
        $this->genders = Gender::all();
    }

    public function render()
    {
        return view('livewire.edit-profile');
    }


    #[On('openEditProfileModal')]
    public function openModal($user)
    {
        $user = (object) $user;

        $this->form->firstName = $user->first_name;
        $this->form->lastName = $user->last_name;
        $this->form->country = $user->country['id'];
        $this->form->gender = $user->gender['id'];
        $this->form->date_of_birth = Carbon::parse($user->date_of_birth)->toDateString();
        $this->form->description = $user->description;

        $this->show = true;
    }

    public function closeModal()
    {
        $this->resetValidation();
        $this->form->reset();
        $this->show = false;
    }

    public function submit()
    {
        $this->form->validate();

        $user = GlobalHelper::getLoggedInUser();
        $user->update([
            'first_name' => $this->form->firstName,
            'last_name' => $this->form->lastName,
            'country_id' => $this->form->country,
            'date_of_birth' => $this->form->date_of_birth,
            'gender_id' => $this->form->gender,
            'description' => $this->form->description,
        ]);

        return redirect()->route('profile');
    }
}
