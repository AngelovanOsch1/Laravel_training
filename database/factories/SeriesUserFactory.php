<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Series;
use App\Models\SeriesUser;
use App\Models\SeriesStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesUserFactory extends Factory
{
    protected $model = SeriesUser::class;

    public function definition()
    {
        return [
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'episode_count' => $this->faker->numberBetween(1, 50),
            'score' => $this->faker->numberBetween(1, 10),
            'user_id' => User::factory(),
            'series_id' => Series::factory(),
            'series_status_id' => SeriesStatus::factory(),
        ];
    }
}
