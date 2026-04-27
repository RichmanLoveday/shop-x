<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

abstract class BaseService
{
    /**
     * Generate unique slug
     */
    protected function generateSlug(string $name, callable $existsCallback): string
    {
        $slug = Str::slug($name, '-');
        $originalSlug = $slug;
        $count = 1;

        while ($existsCallback($slug)) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Handle media upload (Spatie)
     */
    protected function uploadMedia(
        $model,
        UploadedFile $file,
        string $collection = 'default',
        string $column = 'image'
    ): string {
        $model->clearMediaCollection($collection);

        $media = $model
            ->addMedia($file)
            ->usingFileName(uniqid() . '.' . $file->getClientOriginalExtension())
            ->toMediaCollection($collection);

        $model->{$column} = $media->getUrl();
        $model->save();

        return $model->{$column};
    }

}
