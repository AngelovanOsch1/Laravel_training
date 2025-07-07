<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition()
    {
        $contact = Contact::inRandomOrder()->first();

        $senderId = $this->faker->randomElement([$contact->user_one_id, $contact->user_two_id]);

        return [
            'contact_id' => $contact->id,
            'sender_id' => $senderId,
            'body' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
