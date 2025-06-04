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
    public SeriesUser $selectedSeriesUser;

    public function mount()
    {
        $this->series_statuses = SeriesStatus::all();
    }

    #[On('openEditSeriesModal')]
    public function openModal(SeriesUser $seriesUser)
    {
        $this->selectedSeriesUser = $seriesUser;

        $this->form->episode_count = $this->selectedSeriesUser->episode_count;
        $this->form->start_date = Carbon::parse($this->selectedSeriesUser->start_date)->toDateString();
        $this->form->end_date = Carbon::parse($this->selectedSeriesUser->end_date)->toDateString();
        $this->form->score = $this->selectedSeriesUser->score;
        $this->form->series_status = $this->selectedSeriesUser->seriesStatus->id;

        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function submit()
    {
        $this->form->validate();

        $this->selectedSeriesUser->update([
            'start_date' => $this->form->start_date,
            'end_date' => $this->form->end_date,
            'episode_count' => $this->form->episode_count,
            'score' => $this->form->score,
            'user_id' => $this->selectedSeriesUser->user_id,
            'series_id' => $this->selectedSeriesUser->series->id,
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
