<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeriesListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'cover_image' => url("storage/{$this->cover_image}"),
            'episode_count' => $this->episode_count,
            'minutes_per_episode' => $this->minutes_per_episode,
            'aired_start_date' => $this->aired_start_date->toDateString(),
            'aired_end_date' => $this->aired_end_date->toDateString(),
            'synopsis' => $this->synopsis,
            'video' => $this->video,
            'score' => (float) $this->score,
        ];
    }
}
