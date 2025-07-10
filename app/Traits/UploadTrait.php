<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    /**
     * delete specified file in storage
     * @param string $file
     * @return void
     */

    public function remove(string $file): void
    {
        if ($this->exist($file)) Storage::delete($file);
    }

    /**
     * check specified file in storage
     * @param string $file
     * @return bool
     */

    public function exist(string $file): bool
    {
        return Storage::exists($file);
    }

    /**
     * Handle upload file to storage
     * @param string $disk
     * @param UploadedFile $file
     * @param bool $originalName
     * @return string
     */

    public function upload(string $disk, UploadedFile $file, bool $originalName = false): string
    {
        if (!$this->exist($disk)) Storage::makeDirectory($disk);

        if ($originalName) {
            return $file->storeAs($disk, $file->getClientOriginalName());
        }

        return Storage::put($disk, $file);
    }

    /**
     * uploadSlug
     *
     * @param  mixed $disk
     * @param  mixed $file
     * @param  mixed $slug
     * @param  mixed $originalName
     * @return string
     */
    public function uploadSlug(string $disk, UploadedFile $file, string $slug, bool $originalName = false): string
    {
        if (!Storage::exists($disk)) {
            Storage::makeDirectory($disk);
        }

        $slug = str_replace(' ', '-', $slug);
        $slug = str_replace(':', '-', $slug);

        $fileName = $originalName ? $file->getClientOriginalName() : $slug . '.' . $file->getClientOriginalExtension();

        return $file->storeAs($disk, $fileName);
    }
}
