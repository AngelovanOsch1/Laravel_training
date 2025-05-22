<?php

namespace App\Livewire;

use App\Livewire\Forms\SeriesFormValidation;
use App\Models\Series;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;

class AddSeriesToYourList extends Component
{
    public bool $show = false;
    public int $stepCount = 0;
    public string $query = '';
    public Collection $results;
    public array|null $selectedSeries = null;
    public SeriesFormValidation $form;

    public function render()
    {
        return view('livewire.add-series-to-your-list');
    }

    private function submit() {}

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
