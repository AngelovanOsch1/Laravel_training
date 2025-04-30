<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'date_of_birth' => fake()->date('Y-m-d', '2000-01-01'),
            'country' => fake()->country(),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'profile_photo' => '',
        ];
    }
}
