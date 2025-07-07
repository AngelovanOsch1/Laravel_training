<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class Rolefactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(['User', 'Moderator', 'Admin', 'User2', 'Moderator2', 'Admin2', 'User3', 'Moderator3', 'Admin3']),
        ];
    }
}
