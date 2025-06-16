<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Series;
use Livewire\Component;
use App\Models\SeriesUser;
use Livewire\Attributes\On;
use App\Models\SeriesStatus;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Carbon\Carbon;


#[Layout('layouts.app')]
class UserSeriesList extends Component
{
    use WithPagination;

    public $sortField = 'score';
    public $sortDirection = 'desc';
    public User $user;
    public $pivotSortable = ['episode_count', 'score', 'series_status_id', 'start_date'];
    public string $query = '';


    public function mount($id = null)
    {
        $this->user = User::findOrFail($id);
    }

    public function render()
    {
        $seriesQuery = $this->user->series();

        if (strlen($this->query) >= 2) {
            $seriesQuery->where('title', 'like', "%{$this->query}%");
        }

        if (in_array($this->sortField, $this->pivotSortable)) {
            $seriesQuery->orderByPivot($this->sortField, $this->sortDirection);
        } else {
            $seriesQuery->orderBy($this->sortField, $this->sortDirection);
        }

        $seriesList = $seriesQuery->paginate(50);

        $statusMap = SeriesStatus::all()->keyBy('id');

        foreach ($seriesList as $series) {
            $series->pivot->status_name = $statusMap[$series->pivot->series_status_id]->name;
        }

        return view('livewire.user-series-list', [
            'seriesList' => $seriesList,
        ]);
    }


    public function sortBy(string $field)
    {
        $this->sortField = $field;

        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->resetPage();
    }

    public function openDeleteSeriesModal($id)
    {
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
        $seriesUser = SeriesUser::findOrFail($id);

        $seriesUser->delete();

        Series::calculateSeriesTotalScore($seriesUser->series_id);
    }

    public function openAddSeriesToYourListModal()
    {
        $this->dispatch('openAddSeriesToYourListModal');
    }

    public function openEditSeriesModal(int $id)
    {
        $seriesUser = SeriesUser::with(['series', 'seriesStatus'])->find($id);

        $this->dispatch('openEditSeriesModal', $seriesUser);
    }

    #[On('seriesUpdated')]
    public function refreshSeries() {}
}
