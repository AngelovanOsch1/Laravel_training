<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Series;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;
use App\Http\Resources\SeriesResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\SeriesListResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesControllerTest extends TestCase
{
    use RefreshDatabase;
    private array $postData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withHeaders([
            'Authorization' => config('app.secret'),
        ]);

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
        $series = Series::factory()->count(2)->create();

        $expectedData = SeriesListResource::collection($series)->response()->getData(true)['data'];

        $response = $this->get(route('series.index'));

        $response->assertStatus(200);
        $this->assertEquals($expectedData, $response->json('data'));
    }

    public function test_show_route()
    {
        $series = Series::factory()
            ->hasGenres(2)
            ->hasStudios(1)
            ->hasThemes(3)
            ->create();

        $series->load(['genres', 'studios', 'themes']);

        $expectedData = (new SeriesResource($series))->response()->getData(true);

        $response = $this->get(route('series.show', $series));

        $response->assertStatus(200);
        $this->assertEquals($expectedData, $response->json());
    }

    public function test_store_route()
    {
        $coverImage = 'series/' . $this->postData['cover_image']->hashName();

        $response = $this->post(route('series.store'), $this->postData);
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
            'cover_image' => $coverImage
        ]);

        $series = Series::latest()->first();
        $expectedData = (new SeriesListResource($series))->response()->getData(true);

        $this->assertEquals($expectedData, $response->json());
        $response->assertStatus(201);
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
        $series->load(['genres', 'studios', 'themes']);

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

        $expectedData = (new SeriesResource($series))->response()->getData(true);

        $this->assertEquals($expectedData, $response->json());
        $response->assertStatus(200);
    }

    public function test_destroy_route()
    {
        $series = Series::factory()->create();

        $response = $this->delete(route('series.destroy', $series));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('series', [
            'id' => $series->id,
        ]);

        $this->assertEquals(
            ResponseResource::DELETED_SERIES,
            $response->json('data.response')
        );
    }
}
