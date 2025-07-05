<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReactionFactory extends Factory
{
    protected $model = Reaction::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement([User::class, Comment::class]);

        $model = $type === User::class
            ? User::factory()->create()
            : Comment::factory()->create();

        return [
            'reactionable_type' => $type,
            'reactionable_id' => $model->id,
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['like', 'dislike']),
        ];
    }
}
