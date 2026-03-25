<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait HasMediaUpload
{
    /**
     * Upload image to a specific media collection with folder name logic
     */
    public function uploadMediaImage(
        UploadedFile $file,
        string $collection = 'default',
        string $folder = null
    ) {
        $media = $this
            ->addMedia($file)
            ->usingFileName($this->generateFileName($file))
            ->toMediaCollection($collection);

        // If you still want folder-like grouping inside Spatie
        // we store folder name as custom property
        if ($folder) {
            $media->setCustomProperty('images', $folder);
            $media->save();
        }

        return $media;
    }

    /**
     * Get image URL
     */
    public function getImageUrl(string $collection = 'default', string $conversion = '')
    {
        return $this->getFirstMediaUrl($collection, $conversion);
    }

    /**
     * Delete media
     */
    public function deleteMediaImage(string $collection = 'default')
    {
        $this->clearMediaCollection($collection);
    }

    /**
     * Generate unique filename
     */
    private function generateFileName(UploadedFile $file): string
    {
        return uniqid() . '.' . $file->getClientOriginalExtension();
    }
}
