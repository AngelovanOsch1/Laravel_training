<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\SeriesUser;
use App\Support\GlobalHelper;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;


#[Layout('layouts.app')]
class UserSeriesList extends Component
{
    use WithPagination;

    public $sortField = 'id';
    public $sortDirection = 'asc';
    public User $user;

    public function mount()
    {
        $this->user = GlobalHelper::getLoggedInUser();
    }

    public function render()
    {
        $seriesUser = SeriesUser::with(['series', 'seriesStatus'])
            ->where('user_id', $this->user->id)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(50);

        return view('livewire.user-series-list', ['seriesUser' => $seriesUser]);
    }

    public function sortBy(string $field)
    {
        $this->sortField = $field;

        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

        $this->resetPage();
    }

    public function openDeleteSeriesModal($id) {
            $data = [
                'body' => 'Are you sure you want to delete this entry?',
                'callBackFunction' => 'deleteSeriesEntry',
                'callBackFunctionParameter' => $id
            ];

            $this->dispatch('openWarningModal', $data);
    }

    #[On('deleteSeriesEntry')]
    public function deleteSeries(int $id)
    {
        SeriesUser::destroy($id);
    }

    public function openAddSeriesToYourListModal()
    {
        $this->dispatch('openAddSeriesToYourListModal');
    }

    public function openEditSeriesModal(int $id)
    {
        $series = SeriesUser::with(['series', 'seriesStatus'])->findOrFail($id);

        $this->dispatch('openEditSeriesModal', $series);
    }

}
