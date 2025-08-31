<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesImageCoverRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cover_image' => 'required|file|mimes:jpeg,png,webp,jpg|max:10240',
        ];
    }
}
