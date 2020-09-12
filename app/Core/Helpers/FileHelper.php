<?php

namespace App\Core\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
    /**
     * @param $content
     * @param $filename
     * @param string $disk
     * @return bool
     */
    public static function writeArchive($content, $filename, $disk = 'public')
    {
        return Storage::disk($disk)->put($filename, $content, 'public');
    }
}
