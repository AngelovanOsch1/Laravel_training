<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    protected $model = \App\Models\Country::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->country(),
        ];
    }
}
