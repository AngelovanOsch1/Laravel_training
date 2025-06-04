<?php

namespace Database\Factories;

use App\Models\SeriesStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesStatusFactory extends Factory
{
    protected $model = SeriesStatus::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Watching', 'Completed', 'Dropped', 'Plan to watch', 'On-Hold']),
        ];
    }
}
