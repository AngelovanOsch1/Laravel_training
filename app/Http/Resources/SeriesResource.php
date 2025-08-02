<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeriesResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'cover_image_url' => url("storage/{$this->cover_image}"),
            'video' => $this->video,
            'episode_count' => $this->episode_count,
            'minutes_per_episode' => $this->minutes_per_episode,
            'aired_start_date' => $this->aired_start_date->toDateString(),
            'aired_end_date' => $this->aired_end_date->toDateString(),
            'score' => (float) $this->score,
            'synopsis' => $this->synopsis,
            'genres' => GenreResource::collection($this->whenLoaded('genres')),
            'studios' => StudioResource::collection($this->whenLoaded('studios')),
            'character_voice_actors' => CharacterVoiceActorSeriesResource::collection($this->whenLoaded('characterVoiceActorSeries')),
            'themes' => ThemeResource::collection($this->whenLoaded('themes')),
        ];
    }
}
