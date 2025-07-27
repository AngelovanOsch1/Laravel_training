<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'date_of_birth',
        'country_id',
        'gender_id',
        'description',
        'profile_photo',
        'profile_banner',
        'is_blocked',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'password' => 'hashed',
            'is_blocked' => 'boolean',
        ];
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function seriesProgress()
    {
        return $this->hasMany(SeriesUser::class);
    }

    public function series()
    {
        return $this->belongsToMany(Series::class, 'series_user')
            ->using(SeriesUser::class)
            ->withPivot([
                'id',
                'start_date',
                'end_date',
                'episode_count',
                'score',
                'series_status_id'
            ]);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactionable');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function getIsOnlineAttribute()
    {
        $threshold = now()->subMinutes(10)->timestamp;

        return $this->sessions()
            ->where('last_activity', '>=', $threshold)
            ->exists();
    }
}
