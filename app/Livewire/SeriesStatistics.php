<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\SeriesUser;
use Illuminate\Support\Str;
use App\Models\SeriesStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SeriesStatistics extends Component
{
    public User $user;

    public object $totalWatchTime;
    public Collection $totalSeriesStatusCounts;

    public function mount(int $id)
    {
        $this->user = User::findOrFail($id);
    }

    public function render()
    {
        $series = SeriesUser::select(
            DB::raw('SUM(series_user.episode_count * series.minutes_per_episode) as total_minutes'),
            DB::raw('COUNT(DISTINCT series_user.series_id) as total_series')
        )
            ->join('series', 'series_id', '=', 'series.id')
            ->where('user_id', $this->user->id)
            ->first();

        $seriesStatusCounts = SeriesUser::select('series_status_id', DB::raw('count(*) as count'))
            ->join('series_statuses', 'series_status_id', '=', 'series_statuses.id')
            ->where('user_id', $this->user->id)
            ->groupBy('series_status_id')
            ->get()
            ->toArray();


        $countsByStatusId = collect($seriesStatusCounts)->keyBy('series_status_id');

        $statusMap = SeriesStatus::all()->keyBy('id');

        $this->totalSeriesStatusCounts = $statusMap->mapWithKeys(function ($status, $id) use ($countsByStatusId) {
            $key = Str::camel($status->name);
            return [
                $key => (object) [
                    'id' => $id,
                    'name' => $status->name,
                    'count' => $countsByStatusId->has($id) ? $countsByStatusId[$id]['count'] : 0,
                ],
            ];
        });

        $this->totalWatchTime = (object) [
            'totalSeries' => $series['total_series'] ?? 0,
            'totalMinutes' => $series['total_minutes'] ?? 0,
            'totalHours' => $series['total_minutes'] / 60,
            'totalDays' => $series['total_minutes'] / 60 / 24,
            'totalWeeks' => $series['total_minutes'] / 60 / 24 / 7,
        ];

        return view('livewire.series-statistics');
    }
}
