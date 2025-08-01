<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesRequest extends FormRequest
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
        ];
    }
}
