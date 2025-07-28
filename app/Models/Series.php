<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'episode_count',
        'minutes_per_episode',
        'aired_start_date',
        'aired_end_date',
        'score',
        'cover_image',
        'type',
        'synopsis'
    ];

    protected function casts(): array
    {
        return [
            'aired_start_date' => 'date',
            'aired_end_date' => 'date',
        ];
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function themes()
    {
        return $this->hasMany(Theme::class);
    }

    public function studios()
    {
        return $this->belongsToMany(Studio::class);
    }

    public function characterVoiceActorSeries()
    {
        return $this->hasMany(CharacterVoiceActorSeries::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(SeriesUser::class)
            ->withPivot([
                'series_status_id',
                'start_date',
                'end_date',
                'episode_count',
                'score'
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

    public static function calculateSeriesTotalScore($id)
    {
        $seriesCollection = SeriesUser::where('series_id', $id)->get();

        $seriesScore = $seriesCollection->isEmpty()
            ? 0.00
            : $seriesCollection->avg('score');

        $series = Series::findOrFail($id);
        $series->update([
            'score' => $seriesScore,
        ]);
    }

    public function authUserReactedWith($type)
    {
        return $this->reactions
            ->where('user_id', Auth::id())
            ->where('type', $type)
            ->isNotEmpty();
    }

    public static function booted()
    {
        static::creating(function ($series) {
            $series->owner_id = Auth::id();
        });
    }
}
