<?php

namespace App\Livewire;

use Livewire\Component;
use App\Mail\ContactUsMessage;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Livewire\Forms\ContactUsForm;

#[Layout('layouts.app')]
class ContactUs extends Component
{
    public ContactUsForm $form;

    public function render()
    {
        return view('livewire.contact-us');
    }

    public function submit()
    {
        $this->form->validate();

        Mail::to(env('CONTACT_US_RECEIVER'))->send(
            new ContactUsMessage(
                $this->form->name,
                $this->form->email,
                $this->form->message
            )
        );

        session()->flash('success', 'Your message was sent successfully!');
        return redirect()->route('profile', ['id' => Auth::user()->id]);
    }
}
