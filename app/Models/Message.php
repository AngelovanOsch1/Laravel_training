<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory, BroadcastsEvents;

    protected $fillable = ['contact_id', 'sender_id', 'body', 'photo'];

    // Your fillable or guarded properties, relationships, etc.

    /**
     * Get the channels that model events should broadcast on.
     *
     * @param  string  $event
     * @return array<int, \Illuminate\Broadcasting\Channel|\Illuminate\Database\Eloquent\Model>
     */

    public function broadcastOn(string $event): array
    {
        return [new \Illuminate\Broadcasting\PrivateChannel('chat.' . $this->contact_id)];
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
