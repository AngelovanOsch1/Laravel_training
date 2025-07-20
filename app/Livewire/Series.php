<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\SeriesUser;
use App\Support\GlobalHelper;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use App\Models\Series as SeriesModel;

#[Layout('layouts.app')]
class Series extends Component
{
    public User $loggedInUser;
    public SeriesModel $series;

    public function mount(int $id)
    {
        $this->series = SeriesModel::with('genres')->find($id);
        $this->loggedInUser = GlobalHelper::getLoggedInUser();
        $this->series->amount_of_votes = SeriesUser::where('series_id', $this->series->id)->count();
        $this->series->rank = SeriesModel::where('score', '>', $this->series->score)->count() + 1;
        $this->series->airing_status = $this->calculateAiringStatus($this->series);
        $this->series->premiered = $this->getSeasonFromDate(Carbon::parse($this->series->aired_start_date));
    }

    public function render()
    {
        return view('livewire.series');
    }

    public function calculateAiringStatus(SeriesModel $series)
    {
        $today = now();
        $start = Carbon::parse($series->aired_start_date);
        $end = Carbon::parse($series->aired_end_date);

        if ($today->lt($start)) return 'Not yet aired';
        if ($today->between($start, $end)) return 'Airing';
        return 'Finished Airing';
    }

    function getSeasonFromDate(Carbon $date): string
    {
        $year = $date->year;
        $month = $date->month;

        return match (true) {
            $month >= 1 && $month <= 3 => "Winter $year",
            $month >= 4 && $month <= 6 => "Spring $year",
            $month >= 7 && $month <= 9 => "Summer $year",
            $month >= 10 && $month <= 12 => "Fall $year",
        };
    }
}
