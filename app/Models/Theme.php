<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_id',
        'title',
        'artist',
        'audio_url',
        'type',
    ];

    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}
