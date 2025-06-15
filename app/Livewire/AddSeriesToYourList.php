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
    public int $amount = 20;

    public function mount()
    {
        $this->user = GlobalHelper::getLoggedInUser();
    }

    public function render()
    {
        $this->series_statuses = SeriesStatus::all();

        $this->excludedSeriesIds = SeriesUser::where('user_id', $this->user->id)
            ->pluck('series_id')
            ->toArray();

        $query = Series::whereNotIn('id', $this->excludedSeriesIds)
            ->orderBy('score', 'desc');

        if (strlen($this->query) >= 2) {
            $query->where('title', 'like', "%{$this->query}%");
        }

        $this->results = $query->limit($this->amount)->get();

        return view('livewire.add-series-to-your-list');
    }

    public function loadMore()
    {
        $this->amount += 20;
    }

    public function submit()
    {
        $this->form->validate();

        SeriesUser::create([
            'start_date' => $this->form->start_date,
            'end_date' => $this->form->end_date,
            'episode_count' => $this->form->episode_count,
            'score' => $this->form->score,
            'user_id' => $this->user->id,
            'series_id' => $this->selectedSeries['id'],
            'series_status_id' => $this->form->series_status,
        ]);

        Series::calculateSeriesTotalScore($this->selectedSeries['id']);

        return redirect()->route('series-list', $this->user->id);
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
