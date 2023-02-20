<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait CandidatePhoto
{
    /**
     * Update the photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updatePhoto(UploadedFile $photo): void
    {
        tap($this->candidate_photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'candidate_photo_path' => $photo->storePublicly(
                    'candidates', ['disk' => $this->coverPhotoDisk()]
                ),
            ])->save();

            $this->deletingPhoto($previous);
        });
    }

    private function deletingPhoto(string $delete = null): void
    {
        if ($delete) {
            Storage::disk($this->coverPhotoDisk())->delete($delete);
        }
    }

    /**
     * Delete the photo.
     *
     * @return void
     */
    public function deletePhoto(): void
    {
        $this->deletingPhoto($this->candidate_photo_path);

        $this->forceFill([
            'candidate_photo_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the photo.
     *
     * @return string
     */
    public function photo(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->candidate_photo_path
            ? Storage::disk($this->coverPhotoDisk())->url($this->candidate_photo_path)
            : $this->defaultCoverUrl()
        );
    }

    /**
     * Get the default photo URL if no photo has been uploaded.
     *
     * @return string
     */
    protected function defaultCoverUrl(): string
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that photos should be stored on.
     *
     * @return string
     */
    protected function coverPhotoDisk(): string
    {
        return 'public';
    }
}
