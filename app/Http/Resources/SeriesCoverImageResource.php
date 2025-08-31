<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeriesCoverImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'cover_image' => url("storage/{$this->cover_image}"),
        ];
    }
}
