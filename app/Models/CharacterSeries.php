<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterSeries extends Model
{
    use HasFactory;

    protected $table = 'character_series';

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function voiceActors()
    {
        return $this->belongsToMany(VoiceActor::class, 'character_voice_actor');
    }
}
