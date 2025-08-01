<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'commentable_id',
        'commentable_type',
        'user_id',
        'parent_id',
        'is_deleted',
        'is_edited',
        'photo',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->latest();
    }

    protected static function booted()
    {
        static::deleting(function ($comment) {
            $comment->replies()->delete();
            $comment->reactions()->delete();
        });
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactionable');
    }

    public function authUserReactedWith($type)
    {
        return $this->reactions
            ->where('user_id', Auth::id())
            ->where('type', $type)
            ->isNotEmpty();
    }
}
