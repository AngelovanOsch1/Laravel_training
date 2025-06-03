<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Series;
use Livewire\Livewire;
use App\Models\SeriesUser;
use App\Livewire\UserSeriesList;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteSeriesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_deletes_a_series_user_record()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $seriesUser = SeriesUser::factory()->create([
            'user_id' => $user->id,
            'series_id' => Series::factory()->create()->id,
        ]);

        Livewire::test(UserSeriesList::class)
            ->call('openDeleteSeriesModal', $seriesUser->id);

        $this->assertDatabaseMissing('series_user', [
            'id' => $seriesUser->id,
        ]);
    }
}
