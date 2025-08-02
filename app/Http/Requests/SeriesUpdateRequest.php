<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cover_image' => 'required|file|mimes:jpeg,png,webp,jpg|max:10240',
            'title' => 'required|string',
            'type' => 'required|string',
            'episode_count' => 'required|integer|min:0',
            'minutes_per_episode' => 'required|integer|min:0',
            'video' => 'required|string',
            'aired_start_date' => 'required|date',
            'aired_end_date' => 'required|date|after_or_equal:aired_start_date',
            'synopsis' => 'required|string',
        ];
    }
}
