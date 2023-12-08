<?php

namespace App\Traits\Attributes;

use App\Models\SpatieMedia;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property-read SpatieMedia $image
 * @property-read ?string $primaryMediaCollection
 * @property-read ?array $allowedMimeTypes
 * @property-read ?bool $responsiveImagesEnabled
 */
trait HasPrimaryImage
{
    use InteractsWithMedia;

    /**
     * Defining Media Collections for Images.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->registerPrimaryMediaCollection();
    }

    /**
     * Defining Media Collections for Images.
     *
     * @return void
     */
    public function registerPrimaryMediaCollection(): void
    {
        $this
            ->addMediaCollection($this->getPrimaryMediaCollection())
            ->acceptsMimeTypes($this->getAllowedMimeTypes())
            ->withResponsiveImagesIf($this->getIsResponsiveImagesEnabled())
            ->singleFile();
    }

    /**
     * Get Primary Media Collection (using class name).
     *
     * @return string
     */
    public function getPrimaryMediaCollection(): string
    {
        return $this->primaryMediaCollection ?? (Str::snake(Str::pluralStudly(class_basename($this))) . '_primary_images');
    }

    /**
     * Get Allowed Mime Types.
     *
     * @return array
     */
    public function getAllowedMimeTypes(): array
    {
        return $this->allowedMimeTypes ?? ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf', 'image/svg'];
    }

    /**
     * Get Is Responsive Images Required.
     *
     * @return bool
     */
    public function getIsResponsiveImagesEnabled(): bool
    {
        return $this->responsiveImagesEnabled ?? true;
    }

    /**
     * Main Image Morph Relation.
     *
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(config('media-library.media_model'), 'model')
            ->where('collection_name', $this->getPrimaryMediaCollection());
    }
}
