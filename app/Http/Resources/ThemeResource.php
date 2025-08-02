<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThemeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'series_id' => $this->series_id,
            'title' => $this->title,
            'artist' => $this->artist,
            'audio_url' => $this->audio_url,
            'type' => $this->type,
        ];
    }
}
