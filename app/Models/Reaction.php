<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    const TYPE_LIKE = 'like';
    const TYPE_DISLIKE = 'dislike';

    protected $fillable = ['user_id', 'reactionable_id', 'reactionable_type', 'type'];


    public function reactionable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
