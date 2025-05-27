<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SeriesUser;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class UserSeriesList extends Component
{
    use WithPagination;

    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $perPage = 50;

    public function render()
    {
        $seriesUser = SeriesUser::with(['series', 'seriesStatus'])
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.user-series-list', ['seriesUser' => $seriesUser]);
    }

    public function sortBy(string $field)
    {
        $this->sortField = $field;

        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

        $this->resetPage();
    }

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
