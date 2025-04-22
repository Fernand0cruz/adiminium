<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class FileUploadService
{
    public function upload(UploadedFile $file, string $directory = 'uploads'): string
    {
        return $file->store($directory, 'public');
    }
}
