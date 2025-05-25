<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class SeriesFormValidation extends Form
{
    public $episodes;
    public $start_date;
    public $end_date;
    public $score;
    public $series_status;

    protected function rules()
    {
        return [
            'episodes' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'score' => 'nullable|integer|min:0|max:10',
            'series_status' => 'required|exists:series_statuses,id',
        ];
    }
}
