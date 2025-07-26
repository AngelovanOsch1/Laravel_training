<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterVoiceActorSeries extends Model
{
    use HasFactory;

    protected $fillable = [
        'character_id',
        'voice_actor_id',
        'series_id',
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function voiceActor()
    {
        return $this->belongsTo(VoiceActor::class);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}
