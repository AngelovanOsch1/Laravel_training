<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Support\GlobalHelper;

class UserHighestRatedEntries extends Component
{
    public User $user;

    public function mount()
    {
        $this->user = GlobalHelper::getLoggedInUser();
    }

    public function render()
    {
        $topRatedSeries = $this->user
            ->series()
            ->orderByPivot('score', 'desc')
            ->take(10)
            ->get();

        return view('livewire.user-highest-rated-entries', ['topRatedSeries' => $topRatedSeries]);
    }
}
