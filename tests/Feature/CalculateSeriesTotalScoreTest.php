<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Series;
use App\Models\SeriesUser;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalculateSeriesTotalScoreTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_correctly_calculates_series_average_score()
    {
        $series = Series::factory()->create();

        $scoreOne = SeriesUser::factory()->create([
            'series_id' => $series->id,
        ]);

        $scoreTwo = SeriesUser::factory()->create([
            'series_id' => $series->id,
        ]);

        $totalScore = $scoreOne->score + $scoreTwo->score;
        $totalSeriesScore = $totalScore / 2;

        Series::calculateSeriesTotalScore($series->id);

        $series = $series->fresh();
        $this->assertEquals($totalSeriesScore, $series->score);
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
