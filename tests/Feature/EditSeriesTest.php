<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Series;
use Livewire\Livewire;
use App\Models\SeriesUser;
use App\Livewire\EditSeries;
use App\Models\SeriesStatus;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditSeriesTest extends TestCase
{
    use RefreshDatabase;

    private array $baseFormData;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $series = Series::factory()->create();

        $seriesUser = SeriesUser::factory()->create([
            'user_id' => $this->user->id,
            'series_id' => $series->id,
        ])->load('series');;

        $this->baseFormData = [
            'form.start_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'form.end_date' => fake()->dateTimeBetween('+1 year', '+2 year')->format('Y-m-d'),
            'form.episodes' => fake()->numberBetween(1, 100),
            'form.score' => fake()->numberBetween(0, 10),
            'form.series_status' => SeriesStatus::factory()->create()->id,
            'selectedSeries' => json_decode(json_encode($seriesUser)),
        ];
    }


    #[Test]
    public function it_edit_series_user_record()
    {
        Livewire::test(EditSeries::class)
            ->set($this->baseFormData)
            ->call('submit');

        $this->assertDatabaseHas('series_user', [
            'start_date' => $this->baseFormData['form.start_date'],
            'end_date' => $this->baseFormData['form.end_date'],
            'episodes' => $this->baseFormData['form.episodes'],
            'score' => $this->baseFormData['form.score'],
            'series_status_id' => $this->baseFormData['form.series_status'],
            'user_id' => $this->baseFormData['selectedSeries']->user_id,
            'series_id' => $this->baseFormData['selectedSeries']->series->id,
        ]);
    }

    #[Test]
    public function it_validates_series_status_required()
    {
        $invalidSeriesStatusData = array_replace($this->baseFormData, [
            'form.series_status' => '',
        ]);

        Livewire::test(EditSeries::class)
            ->set($invalidSeriesStatusData)
            ->call('submit')
            ->assertHasErrors([
                'form.series_status' => 'required'
            ]);
    }
}
