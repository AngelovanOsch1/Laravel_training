<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'type'
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
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
}
