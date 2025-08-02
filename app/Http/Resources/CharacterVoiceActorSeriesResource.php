<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterVoiceActorSeriesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'character' => new CharacterResource($this->whenLoaded('character')),
            'voice_actor' => new VoiceActorResource($this->whenLoaded('voiceActor')),
            'series_id' => $this->series_id,
        ];
    }
}
