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

    public static function getContactList(User $user)
    {
        return self::with(['userOne', 'userTwo'])
            ->where(function ($query) use ($user) {
                $query->where('user_one_id', $user->id)
                    ->where('user_one_visible', true);
            })
            ->orWhere(function ($query) use ($user) {
                $query->where('user_two_id', $user->id)
                    ->where('user_two_visible', true);
            })
            ->get();
    }
}
