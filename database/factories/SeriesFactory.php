<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    protected $model = Series::class;

    public $images = [
        'series/1.jpg',
        'series/2.jpg',
        'series/3.jpg',
        'series/4.jpg',
        'series/5.jpg',
        'series/6.jpg',
        'series/7.jpg',
        'series/8.jpg',
        'series/9.jpg',
        'series/10.jpg',
    ];

    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence(2),
            'type' => $this->faker->randomElement(['TV', 'Movie', 'OVA']),
            'cover_image' => $this->faker->randomElement($this->images),
            'video' => $this->faker->word,
            'episode_count' => $this->faker->numberBetween(1, 100),
            'minutes_per_episode' => $this->faker->numberBetween(10, 100),
            'aired_start_date' => $this->faker->dateTimeBetween('-5 years', '-3 years'),
            'aired_end_date' => $this->faker->dateTimeBetween('-2 years', '+2 years'),
            'score' => $this->faker->numberBetween(1, 10),
            'synopsis' => $this->faker->sentences(10, true),
            'owner_id' => User::factory(),
        ];
    }
}
