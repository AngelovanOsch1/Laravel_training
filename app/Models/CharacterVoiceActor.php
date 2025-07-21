<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterVoiceActor extends Model
{
    use HasFactory;

    protected $table = 'character_voice_actor';

    public function characterSeries()
    {
        return $this->belongsTo(CharacterSeries::class);
    }

    public function voiceActor()
    {
        return $this->belongsTo(VoiceActor::class);
    }
}
