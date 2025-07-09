<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'added_by_user_id',
        'user_one_visible',
        'user_two_visible',
    ];

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by_user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)
            ->latest('created_at');
    }

    public function unreadMessagesFor(User $user)
    {
        return $this->hasMany(Message::class)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false);
    }

    public static function getContactList(User $user)
    {
        return self::with([
            'userOne',
            'userTwo',
            'latestMessage.sender',
        ])
            ->withCount([
                'messages as unread_messages_count' => function ($query) use ($user) {
                    $query->where('sender_id', '!=', $user->id)
                        ->where('is_read', false);
                }
            ])
            ->where(function ($query) use ($user) {
                $query->where('user_one_id', $user->id)
                    ->where('user_one_visible', true);
            })
            ->orWhere(function ($query) use ($user) {
                $query->where('user_two_id', $user->id)
                    ->where('user_two_visible', true);
            })
            ->get()
            ->sortByDesc(fn($contact) => optional($contact->latestMessage)->created_at)
            ->values();
    }


    public static function addUserToContactList(int $id, int $loggedInUserId)
    {
        $userOne = min($loggedInUserId, $id);
        $userTwo = max($loggedInUserId, $id);

        $existingContact = Contact::where('user_one_id', $userOne)
            ->where('user_two_id', $userTwo)
            ->first();

        if ($existingContact) {
            if ($existingContact->user_one_id === $loggedInUserId) {
                $existingContact->user_one_visible = true;
            } else {
                $existingContact->user_two_visible = true;
            }

            $existingContact->save();
            return $existingContact->id;
        }

        $contact = Contact::create([
            'user_one_id' => $userOne,
            'user_two_id' => $userTwo,
            'user_one_visible' => $userOne === $loggedInUserId,
            'user_two_visible' => $userTwo === $loggedInUserId ? false : true,
        ]);

        return $contact->id;
    }
}
