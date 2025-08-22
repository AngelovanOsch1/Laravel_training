<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Series;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;

class SeriesControllerTest extends TestCase
{
    use RefreshDatabase;
    private array $postData;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        User::factory()->create(['id' => 1]);

        $faker = Faker::create();

        $this->postData = [
            'cover_image' => UploadedFile::fake()->create('cover.jpg', 100, 'image/jpeg'),
            'title' => $faker->unique()->sentence(2),
            'type' => $faker->randomElement(['TV', 'Movie', 'OVA']),
            'episode_count' => $faker->numberBetween(1, 100),
            'minutes_per_episode' => $faker->numberBetween(10, 100),
            'video' => $faker->word(),
            'aired_start_date' => $faker->dateTimeBetween('-5 years', '-3 years')->format('Y-m-d'),
            'aired_end_date' => $faker->dateTimeBetween('-2 years', '+2 years')->format('Y-m-d'),
            'synopsis' => $faker->sentences(10, true),
        ];
    }

    public function test_index_route()
    {
        $seriesCollection = Series::factory()->count(3)->create();

        $response = $this->get(route('series.index'));

        $response->assertStatus(200);

        $expected = $seriesCollection->map(function ($series) {
            return [
                'id' => $series->id,
                'title' => $series->title,
                'type' => $series->type,
                'cover_image_url' => url("storage/{$series->cover_image}"),
                'episode_count' => $series->episode_count,
                'minutes_per_episode' => $series->minutes_per_episode,
                'aired_start_date' => $series->aired_start_date->toDateString(),
                'aired_end_date' => $series->aired_end_date->toDateString(),
                'synopsis' => $series->synopsis,
                'video' => $series->video,
                'score' => (float) $series->score,
            ];
        })->toArray();

        $this->assertEquals(
            $expected,
            $response->json('data')
        );
    }

    public function test_index_pagination_page_2()
    {
        Series::factory()->count(6)->create();

        $response = $this->get(route('series.index', ['page' => 2]));

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }

    public function test_index_pagination_page_1000_empty()
    {
        Series::factory()->count(5)->create();

        $response = $this->get(route('series.index', ['page' => 1000]));

        $response->assertStatus(200);
        $this->assertEmpty($response->json('data'));
    }

    public function test_index_no_series()
    {
        $response = $this->get(route('series.index'));

        $response->assertStatus(200);
        $this->assertEmpty($response->json('data'));
    }

    public function test_show_route()
    {
        $series = Series::factory()
            ->hasGenres(2)
            ->hasStudios(1)
            ->hasThemes(3)
            ->create();

        $series->load(['genres', 'studios', 'themes', 'characterVoiceActorSeries.character', 'characterVoiceActorSeries.voiceActor']);

        $expectedData = [
            'data' => [
                'id' => $series->id,
                'title' => $series->title,
                'type' => $series->type,
                'cover_image_url' => url("storage/{$series->cover_image}"),
                'video' => $series->video,
                'episode_count' => $series->episode_count,
                'minutes_per_episode' => $series->minutes_per_episode,
                'aired_start_date' => $series->aired_start_date->toDateString(),
                'aired_end_date' => $series->aired_end_date->toDateString(),
                'score' => (float) $series->score,
                'synopsis' => $series->synopsis,

                'genres' => $series->genres->map(fn($genre) => [
                    'id' => $genre->id,
                    'name' => $genre->name,
                ])->toArray(),

                'studios' => $series->studios->map(fn($studio) => [
                    'id' => $studio->id,
                    'name' => $studio->name,
                ])->toArray(),

                'themes' => $series->themes->map(fn($theme) => [
                    'id' => $theme->id,
                    'series_id' => $theme->series_id,
                    'title' => $theme->title,
                    'artist' => $theme->artist,
                    'audio_url' => $theme->audio_url,
                    'type' => $theme->type,
                ])->toArray(),

                'character_voice_actors' => $series->characterVoiceActorSeries->map(fn($cva) => [
                    'id' => $cva->id,
                    'series_id' => $cva->series_id,
                    'character' => $cva->whenLoaded('character') ? [
                        'id' => $cva->character->id,
                        'name' => $cva->character->name,
                        'image' => $cva->character->image,
                    ] : null,
                    'voice_actor' => $cva->whenLoaded('voiceActor') ? [
                        'id' => $cva->voiceActor->id,
                        'name' => $cva->voiceActor->name,
                        'image' => $cva->voiceActor->image,
                    ] : null,
                ])->toArray(),
            ]
        ];

        $response = $this->get(route('series.show', $series));

        $response->assertStatus(200);
        $this->assertEquals($expectedData, $response->json());
    }

    public function test_show_route_with_invalid_id()
    {
        $invalidId = 0;

        $response = $this->get(route('series.show', $invalidId));

        $response->assertStatus(404);
    }

    public function test_store_route()
    {
        $coverImage = 'series/' . $this->postData['cover_image']->hashName();

        $response = $this->post(route('series.store'), $this->postData);
        $response->assertStatus(201);

        $this->assertTrue(Storage::disk('public')->exists($coverImage));

        $this->assertDatabaseHas('series', [
            'title' => $this->postData['title'],
            'type' => $this->postData['type'],
            'episode_count' => $this->postData['episode_count'],
            'minutes_per_episode' => $this->postData['minutes_per_episode'],
            'video' => $this->postData['video'],
            'aired_start_date' => $this->postData['aired_start_date'],
            'aired_end_date' => $this->postData['aired_end_date'],
            'synopsis' => $this->postData['synopsis'],
            'owner_id' => 1,
            'cover_image' => $coverImage,
        ]);

        $series = Series::latest()->first();

        $expected = [
            'data' => [
                'id' => $series->id,
                'title' => $series->title,
                'type' => $series->type,
                'cover_image_url' => url("storage/{$series->cover_image}"),
                'episode_count' => $series->episode_count,
                'minutes_per_episode' => $series->minutes_per_episode,
                'aired_start_date' => $series->aired_start_date->toDateString(),
                'aired_end_date' => $series->aired_end_date->toDateString(),
                'synopsis' => $series->synopsis,
                'video' => $series->video,
                'score' => (float) $series->score,
            ]
        ];

        $this->assertEquals($expected, $response->json());
    }

    public function test_update_route()
    {
        $existingCoverImage =  UploadedFile::fake()->create('cover.jpg', 100, 'image/jpeg');
        $existingCoverImagePath = Storage::disk('public')->putFile('series', $existingCoverImage);
        $coverImage = 'series/' . $this->postData['cover_image']->hashName();

        $series = Series::factory()->create([
            'cover_image' => $existingCoverImagePath,
            'owner_id' => 1
        ]);

        $response = $this->put(route('series.update', $series->id), $this->postData);

        $this->assertTrue(Storage::disk('public')->exists($coverImage));
        $this->assertFalse(Storage::disk('public')->exists($existingCoverImagePath));

        $series->refresh();

        $this->assertEquals($this->postData['title'], $series->title);
        $this->assertEquals($this->postData['type'], $series->type);
        $this->assertEquals($this->postData['episode_count'], $series->episode_count);
        $this->assertEquals($this->postData['minutes_per_episode'], $series->minutes_per_episode);
        $this->assertEquals($this->postData['video'], $series->video);
        $this->assertEquals($this->postData['aired_start_date'], $series->aired_start_date->toDateString());
        $this->assertEquals($this->postData['aired_end_date'], $series->aired_end_date->toDateString());
        $this->assertEquals($this->postData['synopsis'], $series->synopsis);
        $this->assertEquals(1, $series->owner_id);
        $this->assertEquals($coverImage, $series->cover_image);

        $response->assertStatus(200);

        $expected = [
            'data' => [
                'id' => $series->id,
                'title' => $series->title,
                'type' => $series->type,
                'cover_image_url' => url("storage/{$series->cover_image}"),
                'episode_count' => $series->episode_count,
                'minutes_per_episode' => $series->minutes_per_episode,
                'aired_start_date' => $series->aired_start_date->toDateString(),
                'aired_end_date' => $series->aired_end_date->toDateString(),
                'synopsis' => $series->synopsis,
                'video' => $series->video,
                'score' => (float) $series->score,
            ]
        ];

        $this->assertEquals($expected, $response->json());
    }


    #[DataProvider('requiredFieldProvider')]
    public function test_update_route_requires_required_fields(string $field)
    {
        $series = Series::factory()->create([
            'cover_image' => UploadedFile::fake()->create('cover.jpg', 100, 'image/jpeg'),
            'owner_id' => 1,
        ]);

        $data = $this->postData;
        unset($data[$field]);

        $response = $this->putJson(route('series.update', $series->id), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($field);
    }

    public static function requiredFieldProvider(): array
    {
        return [
            'title is required' => ['title'],
            'type is required' => ['type'],
            'cover_image is required' => ['cover_image'],
            'episode_count is required' => ['episode_count'],
            'minutes_per_episode is required' => ['minutes_per_episode'],
            'aired_start_date is required' => ['aired_start_date'],
            'aired_end_date is required' => ['aired_end_date'],
            'synopsis is required' => ['synopsis'],
            'video is required' => ['video'],
        ];
    }

    public function test_destroy_route()
    {
        $series = Series::factory()->create();

        $response = $this->delete(route('series.destroy', $series));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('series', [
            'id' => $series->id,
        ]);

        $expected = [
            'status' => 'success',
            'message' => 'Successfully deleted series',
            'data' => null,
        ];

        $this->assertEquals($expected, $response->json('data.response'));
    }

    public function test_destroy_with_invalid_id_does_not_delete()
    {
        $invalidId = 0;

        $response = $this->delete(route('series.destroy', $invalidId));

        $response->assertStatus(404);

        $this->assertDatabaseCount('series', 0);
    }
}
