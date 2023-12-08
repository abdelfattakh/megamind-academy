<?php

namespace App\Models;

use App\Traits\Attributes\HasPrimaryImage;
use App\Traits\Attributes\HasTranslatableWithJsonEscape;
use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;

class Partner extends Model implements HasMedia
{
    use HasFactory, HasActiveScope, HasTranslatableWithJsonEscape, HasPrimaryImage;

    /**
     * Media Collection
     */
    public static string $partner_images = 'partner_images';
    /**
     * The attributes that are translatable.
     *
     * @var array<int, string>
     */
    public $translatable = ['name'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'is_active'
    ];

    /**
     * Defining Media Collections for Category Images.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(self::$partner_images)
            ->acceptsMimeTypes($this->getAllowedMimeTypes())
            ->withResponsiveImagesIf($this->getIsResponsiveImagesEnabled());

        $this->registerPrimaryMediaCollection();
    }


    /**
     * Creator Image Morph Relation.
     *
     * @return MorphMany
     */
    public function otherImages(): MorphOne
    {
        return $this->morphOne(config('media-library.media_model'), 'model')
            ->where('collection_name', self::$other_images);
    }
}
