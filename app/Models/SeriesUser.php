<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SeriesUser extends Pivot
{
    use HasFactory;

    protected $table = 'series_user';

    protected $fillable = [
        'start_date',
        'end_date',
        'episode_count',
        'score',
        'user_id',
        'series_id',
        'series_status_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function series()
    {
        return $this->belongsTo(Series::class, 'series_id');
    }

    public function seriesStatus()
    {
        return $this->belongsTo(SeriesStatus::class, 'series_status_id');
    }
}
