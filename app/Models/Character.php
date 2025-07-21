<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    public function series()
    {
        return $this->belongsToMany(Series::class, 'character_series');
    }

    public function characterSeries()
    {
        return $this->hasMany(CharacterSeries::class);
    }
}
