<?php

namespace Database\Factories;

use App\Models\Authentication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AuthenticationFactory extends Factory
{
    protected $model = Authentication::class;

    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('Password123!'),
            'role' => fake()->randomElement(['user', 'mod', 'superUser']),
            'is_online' => false,
            'user_id' => User::factory()->create(),  // Use the created user's ID
        ];
    }
}
