<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Support\GlobalHelper;
use App\Livewire\Forms\EditProfileFormValidation;

class EditProfile extends Component
{
    public EditProfileFormValidation $form;
    public $show = false;

    public function render()
    {
        return view('livewire.edit-profile');
    }


    #[On('openEditProfileModal')]
    public function openModal($user)
    {
        $this->form->firstName = $user['first_name'];
        $this->form->lastName = $user['last_name'];
        $this->form->country = $user['country'];
        $this->form->gender = $user['gender'];
        $this->form->birthYear = Carbon::parse($user['date_of_birth'])->toDateString();
        $this->form->description = $user['description'];

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
            'date_of_birth' => $this->form->birthYear,
            'gender' => $this->form->gender,
            'description' => $this->form->description,
        ]);

        return redirect()->route('profile');
    }
}
