<?php

namespace Database\Factories;

namespace Database\Factories;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        $userIds = User::inRandomOrder()->limit(2)->pluck('id')->sort()->values();

        return [
            'user_one_id' => $userIds[0],
            'user_two_id' => $userIds[1],
            'added_by_user_id' => $this->faker->randomElement([$userIds[0], $userIds[1]]),
            'user_one_visible' => true,
            'user_two_visible' => true,
        ];
    }
}
