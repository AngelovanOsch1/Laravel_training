<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\SeriesUser;
use Livewire\Attributes\On;
use App\Models\SeriesStatus;
use Illuminate\Support\Collection;
use App\Livewire\Forms\SeriesFormValidation;

class EditSeries extends Component
{
    public bool $show = false;
    public SeriesFormValidation $form;
    public Collection $series_statuses;
    public $selectedSeries;

    public function mount()
    {
        $this->series_statuses = SeriesStatus::all();
    }

    #[On('openEditSeriesModal')]
    public function openModal($series)
    {
        $this->selectedSeries = json_decode(json_encode($series));

        $this->form->episode_count = $this->selectedSeries->episode_count;
        $this->form->start_date = Carbon::parse($this->selectedSeries->start_date)->toDateString();
        $this->form->end_date = Carbon::parse($this->selectedSeries->end_date)->toDateString();
        $this->form->score = $this->selectedSeries->score;
        $this->form->series_status = $this->selectedSeries->series_status->id;

        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function submit()
    {
        $this->form->validate();

        $seriesUser = SeriesUser::findOrFail($this->selectedSeries->id);

        $seriesUser->update([
            'start_date' => $this->form->start_date,
            'end_date' => $this->form->end_date,
            'episode_count' => $this->form->episode_count,
            'score' => $this->form->score,
            'user_id' => $this->selectedSeries->user_id,
            'series_id' => $this->selectedSeries->series->id,
            'series_status_id' => $this->form->series_status,
        ]);

        $this->dispatch('seriesUpdated');

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.edit-series');
    }
}
