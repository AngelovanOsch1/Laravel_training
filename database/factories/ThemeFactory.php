<?php

namespace Database\Factories;

use App\Models\Series;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThemeFactory extends Factory
{
    protected $model = Theme::class;

    public function definition(): array
    {
        return [
            'series_id' => Series::factory(),
            'title' => $this->faker->sentence(3),
            'artist' => $this->faker->name,
            'audio_url' => null,
            'type' => $this->faker->randomElement(['opening', 'ending']),
        ];
    }
}
