<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cover_image' => 'required|file|mimes:jpeg,png,webp,jpg|max:10240',
            'title' => 'required|string',
            'type' => 'required|string',
            'genres' => 'required|array',
            'genres.*' => 'integer|exists:genres,id',
            'episode_count' => 'required|integer|min:0',
            'minutes_per_episode' => 'required|integer|min:0',
            'video' => 'required|string',
            'aired_start_date' => 'required|date',
            'aired_end_date' => 'required|date|after_or_equal:aired_start_date',
            'studios' => 'required|array|min:1',
            'studios.*' => 'integer|exists:studios,id',
            'synopsis' => 'required|string',
            'character_voice_actors' => 'required|array',
            'character_voice_actors.*.character_id' => 'required|integer|exists:characters,id',
            'character_voice_actors.*.voice_actor_id' => 'required|integer|exists:voice_actors,id',
            'themes' => 'required|array',
            'themes.*.title' => 'required|string',
            'themes.*.artist' => 'required|string',
            'themes.*.audio_url' => 'required|file|mimes:mp3,wav,ogg|max:10240',
            'themes.*.type' => 'required|string',
        ];
    }
}
