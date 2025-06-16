<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Series;
use Livewire\Livewire;
use App\Models\SeriesStatus;
use App\Livewire\UserSeriesList;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewUsersSeriesListTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_checks_if_search_finds_a_series()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $series = Series::factory()->create();

        $user->series()->attach($series->id, [
            'series_status_id' => SeriesStatus::factory()->create()->id,
        ]);

        Livewire::test(UserSeriesList::class, ['id' => $user->id])
            ->set('query', substr($series->title, 0, 3))
            ->assertSee($series->title);
    }
}
