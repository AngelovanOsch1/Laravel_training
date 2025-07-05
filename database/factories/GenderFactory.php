<?php

namespace Database\Factories;

use App\Models\Gender;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenderFactory extends Factory
{
    protected $model = Gender::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(['Male', 'Female', 'Other', 'Male1', 'Female1', 'Other1', 'Male2', 'Female2', 'Other3']),
        ];
    }
}
