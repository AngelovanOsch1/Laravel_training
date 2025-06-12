<?php

namespace Tests\Feature;

use App\Livewire\SeriesStatistics;
use Tests\TestCase;
use App\Models\User;
use App\Models\Series;
use Livewire\Livewire;
use App\Models\SeriesUser;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class calculateSeriesStatisticsTest extends TestCase
{
    // use RefreshDatabase;

    // public int $total_series_watching = 0;
    // public int $total_series_completed = 0;
    // public int $total_series_on_hold = 0;
    // public int $total_series_dropped = 0;
    // public int $total_series_plan_on_watching = 0;

    // public int $total_series = 0;
    // public int $total_episodes = 0;

    // public int $total_minutes = 0;
    // public float $total_hours = 0;
    // public float $total_days = 0;
    // public float $total_weeks = 0;


    // #[Test]
    // public function it_calculate_series_statistics()
    // {
    //     $user = User::factory()->create();
    //     $this->actingAs($user);

    //     $seriesCollection = Series::factory()->count(10)->create();
    //     $seriesUserCollection = collect();

    //     foreach ($seriesCollection as $series) {
    //         $seriesUser = SeriesUser::factory()->create([
    //             'user_id' => $user->id,
    //             'series_id' => $series->id,
    //         ]);
    //         $seriesUserCollection->push($seriesUser);
    //     }

    //     $seriesUser->load('seriesStatus');

    //     foreach ($seriesUserCollection as $seriesUser) {
    //         $series = $seriesCollection->firstWhere('id', $seriesUser->series_id);
    //         $this->getSeriesCount($seriesUser->seriesStatus->name);
    //         $this->total_minutes = $seriesUser->episode_count * $series->minutes_per_episode;

    //         $this->total_series += +1;
    //         $this->total_episodes += $seriesUser->episode_count;
    //     }

    //     $this->total_hours = $this->total_minutes / 60;
    //     $this->total_days = $this->total_hours / 24;
    //     $this->total_weeks = $this->total_days / 7;

    //     $component = Livewire::test(SeriesStatistics::class, ['id' => $user->id]);

    //     $component->assertSet('total_series_watching', $this->total_series_watching);
    //     $component->assertSet('total_series_completed', $this->total_series_completed);
    //     $component->assertSet('total_series_on_hold', $this->total_series_on_hold);
    //     $component->assertSet('total_series_dropped', $this->total_series_dropped);
    //     $component->assertSet('total_series_plan_on_watching', $this->total_series_plan_on_watching);

    //     $component->assertSet('total_series', $this->total_series);
    //     $component->assertSet('total_episodes', $this->total_episodes);

    //     $component->assertSet('total_minutes', $this->total_minutes);
    //     $component->assertSet('total_hours', $this->total_hours);
    //     $component->assertSet('total_days', $this->total_days);
    //     $component->assertSet('total_weeks', $this->total_weeks);
    // }

    // public function getSeriesCount(string $seriesStatusName)
    // {
    //     switch (strtolower($seriesStatusName)) {
    //         case 'watching':
    //             return $this->total_series_watching += 1;
    //         case 'dropped':
    //             return $this->total_series_dropped += 1;
    //         case 'plan to watch':
    //             return $this->total_series_plan_on_watching += 1;
    //         case 'completed':
    //             return $this->total_series_completed += 1;
    //         case 'on-hold':
    //             return $this->total_series_on_hold += 1;
    //         default:
    //             return null;
    //     }
    // }
}
