<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class UserSeriesList extends Component
{
    public function render()
    {
        return view('livewire.user-series-list');
    }

    public function openAddSeriesToYourListModal()
    {
        $this->dispatch('openAddSeriesToYourListModal');
    }
}
