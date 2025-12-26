<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Upload an image and optionally delete the old one.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $oldPath
     * @param string $disk
     * @return string
     */
    public function upload(UploadedFile $file, string $directory, ?string $oldPath = null, string $disk = 'public'): string
    {
        if ($oldPath) {
            $this->delete($oldPath, $disk);
        }

        return $file->store($directory, $disk);
    }

    /**
     * Delete an image from storage.
     *
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public function delete(string $path, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }
}
