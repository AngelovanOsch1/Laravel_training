<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class SeriesFormValidation extends Form
{
    public $episodes;
    public $start_date;
    public $end_date;
    public $score;
    public $serie_status;

    protected function rules()
    {
        return [
            'episodes' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
            'score' => 'numeric|between:0,10',
            'series_status' => 'exists:series_statuses,name',
        ];
    }
}
