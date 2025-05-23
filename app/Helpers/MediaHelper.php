<?php

namespace App\Helpers;

class MediaHelper
{
    public static function detectMediaType($file)
    {
        $mime = $file->getMimeType();

        if (str_starts_with($mime, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mime, 'audio/')) {
            return 'audio';
        }

        return 'other';
    }
}
