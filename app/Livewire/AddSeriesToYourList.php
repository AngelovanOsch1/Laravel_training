<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Series;
use Livewire\Component;
use App\Models\SeriesUser;
use Livewire\Attributes\On;
use App\Models\SeriesStatus;
use App\Support\GlobalHelper;
use Illuminate\Support\Collection;
use App\Livewire\Forms\SeriesFormValidation;

class AddSeriesToYourList extends Component
{
    public bool $show = false;
    public int $stepCount = 0;
    public string $query = '';
    public Collection $results;
    public array|null $selectedSeries = null;
    public SeriesFormValidation $form;
    public Collection $series_statuses;
    public User $user;
    public array $excludedSeriesIds;

    public function mount()
    {
        $this->user = GlobalHelper::getLoggedInUser();
        $this->excludedSeriesIds = SeriesUser::where('user_id', $this->user->id)
            ->pluck('series_id')
            ->toArray();
        $this->series_statuses = SeriesStatus::all();
    }

    public function render()
    {
        return view('livewire.add-series-to-your-list');
    }

    public function submit()
    {
        $this->form->validate();

        SeriesUser::create([
            'start_date' => $this->form->start_date,
            'end_date' => $this->form->end_date,
            'episodes' => $this->form->episodes,
            'score' => $this->form->score,
            'user_id' => $this->user->id,
            'series_id' => $this->selectedSeries['id'],
            'series_status_id' => $this->form->series_status,
        ]);
        return redirect()->route('series-list');
    }

    public function setSelectedIndex($index)
    {
        $this->selectedSeries = $this->results->firstWhere('id',  $index)->toArray();
    }

    public function nextStep()
    {
        if ($this->stepCount === 1) {
            $this->submit();
        } else {
            $this->stepCount++;
        }
    }

    public function previousStep()
    {
        if ($this->stepCount === 0) {
            $this->closeModal();
        } else {
            $this->stepCount--;
            $this->resetValidation();
            $this->form->reset();
        }
        $this->selectedSeries = null;
        $this->query = '';
    }

    public function updatedQuery()
    {
        if (strlen($this->query) > 2) {
            $this->results = Series::where('title', 'like', "%{$this->query}%")
                ->whereNotIn('id', $this->excludedSeriesIds)
                ->orderBy('score', 'desc')
                ->get();
        } else {
            $this->selectedSeries = null;
        }
    }

    #[On('openAddSeriesToYourListModal')]
    public function openModal()
    {
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
    }
}
