<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class WarningModal extends Component
{
    public $show = false;
    public $error;

    #[On('openWarningModal')]
    public function openModal($data)
    {
        $this->error = $data;
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.warning-modal');
    }
}
