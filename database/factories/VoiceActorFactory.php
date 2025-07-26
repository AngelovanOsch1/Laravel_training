<?php

namespace Database\Factories;

use App\Models\VoiceActor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoiceActorFactory extends Factory
{
    protected $model = VoiceActor::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'image' => $this->faker->imageUrl(200, 200, 'people'),
        ];
    }
}
