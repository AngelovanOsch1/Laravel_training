<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\SeriesStatus;
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

    public function mount(int $id)
    {
        $this->user = User::findOrFail($id);
    }

    public function render()
    {
        $series = $this->user->series()->get();

        $statusMap = SeriesStatus::all()->keyBy('id');

        foreach ($series as $item) {
            $statusName = $statusMap[$item->pivot->series_status_id]->name;

            $this->incrementStatusCount($statusName);
            $this->total_minutes += $item->pivot->episode_count * $item->minutes_per_episode;
            $this->total_episodes += $item->pivot->episode_count;
        }

        $this->total_series = $series->count();
        $this->total_hours = $this->total_minutes / 60;
        $this->total_days = $this->total_hours / 24;
        $this->total_weeks = $this->total_days / 7;

        return view('livewire.series-statistics');
    }


    protected function incrementStatusCount(string $status)
    {
        match (strtolower($status)) {
            'watching'      => $this->total_series_watching++,
            'completed'     => $this->total_series_completed++,
            'on-hold'       => $this->total_series_on_hold++,
            'dropped'       => $this->total_series_dropped++,
            'plan to watch' => $this->total_series_plan_on_watching++,
            default         => null,
        };
    }
}
