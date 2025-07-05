<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'commentable_type' => User::class,
            'commentable_id' => User::factory(),
            'message' => $this->faker->sentence(),
            'is_edited' => false,
            'parent_id' => null,
            'photo' => null,
            'user_id' => User::factory(),
            'created_at' => now(),
        ];
    }
}
