<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Series;
use Livewire\Livewire;
use App\Models\SeriesUser;
use App\Models\SeriesStatus;
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

        $series = Series::factory()->create();

        $user->series()->attach($series->id, [
            'series_status_id' => SeriesStatus::factory()->create()->id,
        ]);

        $seriesUser = SeriesUser::where('user_id', $user->id)
            ->where('series_id', $series->id)
            ->first();

        Livewire::test(UserSeriesList::class, ['id' => $user->id])
            ->call('deleteSeries', $seriesUser->id);

        $this->assertDatabaseMissing('series_user', [
            'id' => $seriesUser->id,
        ]);
    }
}
