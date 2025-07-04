<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Series;
use Livewire\Livewire;
use App\Models\SeriesUser;
use Illuminate\Support\Str;
use App\Models\SeriesStatus;
use App\Livewire\SeriesStatistics;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesStatisticsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_calculates_series_statistics()
    {
        $user = User::factory()->create();
        $series = Series::factory()->count(5)->create();

        $series_status_names = ['Watching', 'Completed', 'Dropped', 'Plan to watch', 'On-Hold'];

        collect($series_status_names)->map(function ($name) {
            return SeriesStatus::create(['name' => $name]);
        });

        foreach ($series as $item) {
            $user->series()->attach($item->id, [
                'series_status_id' => SeriesStatus::factory()->create()->id,
                'episode_count' => fake()->numberBetween(1, 25),
            ]);
        }

        $series = SeriesUser::select(
            DB::raw('SUM(series_user.episode_count * series.minutes_per_episode) as total_minutes'),
            DB::raw('COUNT(DISTINCT series_user.series_id) as total_series')
        )
            ->join('series', 'series_id', '=', 'series.id')
            ->where('user_id', $user->id)
            ->first();

        $seriesStatusCounts = SeriesUser::select('series_status_id', DB::raw('count(*) as count'))
            ->join('series_statuses', 'series_status_id', '=', 'series_statuses.id')
            ->where('user_id', $user->id)
            ->groupBy('series_status_id')
            ->get()
            ->toArray();


        $countsByStatusId = collect($seriesStatusCounts)->keyBy('series_status_id');

        $statusMap = SeriesStatus::all()->keyBy('id');

        $totalSeriesStatusCounts = $statusMap->mapWithKeys(function ($status, $id) use ($countsByStatusId) {
            $key = Str::camel($status->name);
            return [
                $key => (object) [
                    'id' => $id,
                    'name' => $status->name,
                    'count' => $countsByStatusId->has($id) ? $countsByStatusId[$id]['count'] : 0,
                ],
            ];
        });

        $totalWatchTime = (object) [
            'totalSeries' => $series->total_series ?? 0,
            'totalMinutes' => $series->total_minutes ?? 0,
            'totalHours' => $series->total_minutes / 60,
            'totalDays' => $series->total_minutes / 60 / 24,
            'totalWeeks' => $series->total_minutes / 60 / 24 / 7,
        ];

        Livewire::test(SeriesStatistics::class, ['id' => $user->id])
            ->assertSet('totalSeriesStatusCounts.watching.count', $totalSeriesStatusCounts['watching']->count)
            ->assertSet('totalSeriesStatusCounts.completed.count', $totalSeriesStatusCounts['completed']->count)
            ->assertSet('totalSeriesStatusCounts.onHold.count', $totalSeriesStatusCounts['onHold']->count)
            ->assertSet('totalSeriesStatusCounts.dropped.count', $totalSeriesStatusCounts['dropped']->count)
            ->assertSet('totalSeriesStatusCounts.planToWatch.count', $totalSeriesStatusCounts['planToWatch']->count)
            ->assertSet('totalWatchTime.totalSeries', $totalWatchTime->totalSeries)
            ->assertSet('totalWatchTime.totalMinutes', $totalWatchTime->totalMinutes)
            ->assertSet('totalWatchTime.totalHours', $totalWatchTime->totalHours)
            ->assertSet('totalWatchTime.totalDays', $totalWatchTime->totalDays)
            ->assertSet('totalWatchTime.totalWeeks', $totalWatchTime->totalWeeks);
    }
}
