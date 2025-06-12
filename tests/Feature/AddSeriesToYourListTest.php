<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Series;
use Livewire\Livewire;
use App\Models\SeriesUser;
use App\Models\SeriesStatus;
use App\Livewire\AddSeriesToYourList;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddSeriesToYourListTest extends TestCase
{
    use RefreshDatabase;

    private array $baseFormData;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->baseFormData = [
            'form.start_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'form.end_date' => fake()->dateTimeBetween('+1 year', '+2 year')->format('Y-m-d'),
            'form.episode_count' => fake()->numberBetween(1, 100),
            'form.score' => fake()->numberBetween(0, 10),
            'selectedSeries' => ['id' => Series::factory()->create()->id],
            'form.series_status' => SeriesStatus::factory()->create()->id,
        ];
    }

    #[Test]
    public function it_create_series_user_record()
    {
        Livewire::test(AddSeriesToYourList::class, ['id' => $this->user->id])
            ->set($this->baseFormData)
            ->call('submit')
            ->assertRedirect(route('series-list', $this->user->id));


        $this->assertDatabaseHas('series_user', [
            'start_date' => $this->baseFormData['form.start_date'],
            'end_date' => $this->baseFormData['form.end_date'],
            'episode_count' => $this->baseFormData['form.episode_count'],
            'score' => $this->baseFormData['form.score'],
            'user_id' => $this->user->id,
            'series_id' => $this->baseFormData['selectedSeries']['id'],
            'series_status_id' => $this->baseFormData['form.series_status'],
        ]);
    }

    #[Test]
    public function it_validates_series_status_required()
    {
        $invalidSeriesStatusData = array_replace($this->baseFormData, [
            'form.series_status' => '',
        ]);

        Livewire::test(AddSeriesToYourList::class)
            ->set($invalidSeriesStatusData)
            ->call('submit')
            ->assertHasErrors([
                'form.series_status' => 'required'
            ]);
    }

    #[Test]
    public function it_populates_results_when_query_is_updated()
    {
        $series = Series::factory()->create();

        Livewire::test(AddSeriesToYourList::class)
            ->set('query', substr($series->title, 0, 3))
            ->assertSet('results', function ($results) use ($series) {
                return $results->contains('id', $series->id);
            });
    }

    #[Test]
    public function it_excludes_already_added_series_from_results()
    {
        $series = Series::factory()->create();

        SeriesUser::factory()->create([
            'user_id' => $this->user->id,
            'series_id' => $series->id,
        ]);

        Livewire::test(AddSeriesToYourList::class)
            ->set('query', substr($series->title, 0, 3))
            ->assertSet('results', function ($results) use ($series) {
                return !$results->contains('id', $series->id);
            });
    }
}
