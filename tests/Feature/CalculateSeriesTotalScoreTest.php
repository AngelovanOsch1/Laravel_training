<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Series;
use App\Models\SeriesUser;
use App\Models\SeriesStatus;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalculateSeriesTotalScoreTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_correctly_calculates_series_average_score()
    {
        $series = Series::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $user1->series()->attach($series->id, [
            'series_status_id' => SeriesStatus::factory()->create()->id,
            'score' => fake()->numberBetween(1, 10),
        ]);

        $user2->series()->attach($series->id, [
            'series_status_id' => SeriesStatus::factory()->create()->id,
            'score' => fake()->numberBetween(1, 10),
        ]);

        $seriesUserOne = SeriesUser::where('user_id', $user1->id)
            ->where('series_id', $series->id)
            ->first();

        $seriesUserTwo = SeriesUser::where('user_id', $user2->id)
            ->where('series_id', $series->id)
            ->first();

        $expectedAverage = ($seriesUserOne->score + $seriesUserTwo->score) / 2;

        Series::calculateSeriesTotalScore($series->id);

        $series = $series->fresh();

        $this->assertEquals($expectedAverage, $series->score);
    }



    #[Test]
    public function it_sets_score_to_zero_if_no_entries_exist()
    {
        $series = Series::factory()->create();

        Series::calculateSeriesTotalScore($series->id);

        $series = $series->fresh();
        $this->assertEquals(0.0, $series->score);
    }
}
