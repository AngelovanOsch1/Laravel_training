<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'country',
        'gender',
        'profile_photo'
    ];

    public function authentication()
    {
        return $this->hasOne(Authentication::class, 'user_id');
    }

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'is_online' => 'boolean',
        ];
    }
}
