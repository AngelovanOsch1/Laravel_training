<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\Gender;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('Password123!'),
            'role_id' => Role::firstOrCreate(['name' => 'User']),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'date_of_birth' => fake()->date('Y-m-d', '2000-01-01'),
            'country_id' => Country::factory(),
            'gender_id' => Gender::factory(),
            'profile_photo' => null,
            'profile_banner' => null,
            'description' => Str::limit(implode(' ', $this->faker->sentences(5)), 100),
            'is_blocked' => false,
        ];
    }
}
