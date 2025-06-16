<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait HandlesPhotos
{
    public function uploadPhoto(UploadedFile $photo, string $directory = 'photos')
    {
        return Storage::disk('public')->put($directory, $photo);
    }

    public function deletePhoto(string $path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
    }
}
