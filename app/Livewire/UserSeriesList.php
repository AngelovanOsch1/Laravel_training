<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\SeriesUser;
use Livewire\Attributes\On;
use App\Models\SeriesStatus;
use Livewire\WithPagination;
use App\Support\GlobalHelper;
use Livewire\Attributes\Layout;


#[Layout('layouts.app')]
class UserSeriesList extends Component
{
    use WithPagination;

    public $sortField = 'score';
    public $sortDirection = 'desc';
    public User $user;
    public $pivotSortable = ['episode_count', 'score', 'series_status_id', 'start_date'];

    public function mount($id = null)
    {
        $this->user = User::findOrFail($id);
    }

    public function render()
    {
        $seriesQuery = $this->user->series();

        if (in_array($this->sortField, $this->pivotSortable)) {
            $seriesQuery->orderByPivot($this->sortField, $this->sortDirection);
        } else {
            $seriesQuery->orderBy($this->sortField, $this->sortDirection);
        }

        $seriesList = $seriesQuery->paginate(50);

        $statusIds = $seriesList->getCollection()->pluck('pivot.series_status_id')->unique();

        $statuses = SeriesStatus::whereIn('id', $statusIds)->get()->keyBy('id');
        $seriesList->getCollection()->each(function ($series) use ($statuses) {
            $series->pivot->setRelation('seriesStatus', $statuses->get($series->pivot->series_status_id));
        });

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
        SeriesUser::destroy($id);
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
