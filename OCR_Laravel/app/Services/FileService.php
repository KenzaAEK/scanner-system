<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public static function saveUploadedFile($file, $directory)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs($directory, $filename);
        return storage_path('app/' . $path);
    }
}