<?php

namespace App\Models;

use App\Models\Comment;
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
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'password' => 'hashed',
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
}
