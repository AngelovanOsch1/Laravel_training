<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Session;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    protected $model = Session::class;

    public function definition()
    {
        return [
            'id' => Str::random(40),
            'user_id' => User::factory(),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'payload' => base64_encode(serialize(['_token' => 'dummy'])),
            'last_activity' => now()->timestamp,
        ];
    }
}
