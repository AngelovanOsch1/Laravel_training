<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\SeriesStatus;
use App\Support\GlobalHelper;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class SeriesStatistics extends Component
{
    public User $user;

    public int $total_series_watching = 0;
    public int $total_series_completed = 0;
    public int $total_series_on_hold = 0;
    public int $total_series_dropped = 0;
    public int $total_series_plan_on_watching = 0;

    public int $total_series = 0;
    public int $total_episodes = 0;

    public int $total_minutes = 0;
    public float $total_hours = 0;
    public float $total_days = 0;
    public float $total_weeks = 0;

    public function mount()
    {
        $this->user = GlobalHelper::getLoggedInUser();
    }

    public function render()
    {
        $series = $this->user->series()->get();

        $statusIds = $series->pluck('pivot.series_status_id')->unique();

        $statuses = SeriesStatus::whereIn('id', $statusIds)->get()->keyBy('id');

        $series->each(function ($seriesItem) use ($statuses) {
            $seriesItem->pivot->setRelation('seriesStatus', $statuses->get($seriesItem->pivot->series_status_id));
        });

        $this->calculateSeriesStatistics($series);

        return view('livewire.series-statistics');
    }

    public function calculateSeriesStatistics($series)
    {
        foreach ($series as $item) {
            $this->getSeriesCount($item->pivot->seriesStatus->name);
            $this->total_minutes = $item->pivot->episode_count * $item->minutes_per_episode;

            $this->total_series += 1;
            $this->total_episodes += $item->pivot->episode_count;
        }

        $this->total_hours = $this->total_minutes / 60;
        $this->total_days = $this->total_hours / 24;
        $this->total_weeks = $this->total_days / 7;
    }

    public function getSeriesCount(string $seriesStatusName)
    {
        switch (strtolower($seriesStatusName)) {
            case 'watching':
                return $this->total_series_watching += 1;
            case 'dropped':
                return $this->total_series_dropped += 1;
            case 'plan to watch':
                return $this->total_series_plan_on_watching += 1;
            case 'completed':
                return $this->total_series_completed += 1;
            case 'on-hold':
                return $this->total_series_on_hold += 1;
            default:
                return null;
        }
    }
}
