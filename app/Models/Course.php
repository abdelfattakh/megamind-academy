<?php

namespace App\Models;

use App\Traits\Attributes\HasPrimaryImage;
use App\Traits\Attributes\HasTranslatableWithJsonEscape;
use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\MediaLibrary\HasMedia;

class Course extends Model implements HasMedia
{
    use HasFactory, HasActiveScope, HasTranslatableWithJsonEscape, HasPrimaryImage, HasSEO;

    /**
     * The attributes that should be translatable.
     *
     * @var array<string, string>
     */
    public $translatable = ['name', 'description'];

    /**
     * Allowed Mime Types for def. collection.
     *
     * @var array<string, string>
     */
    public $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg', 'video/mp4'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'prerequisites' => 'array',
        'curriculum' => 'array',
        'course_location' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'course_bookings',
        'prerequisites',
        'curriculum',
        'course_location',
        'category_id',
        'is_active',
        'is_top_course',
        'price',
        'discount_value',
        'discount_expiration_date',
        'session_no',
        'udemy_course_link'
    ];

    /**
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            $price = $model->getAttribute('price') ?? 0;
            $discount = $model->getAttribute('discount_value') ?? 0;
            $model->final_price = $price - $discount;
        });

        static::updating(function (self $model) {
            $price = $model->getAttribute('price') ?? 0;
            $discount = $model->getAttribute('discount_value') ?? 0;
            $model->final_price = $price - $discount;
        });
    }

    /**
     * Course Belongs to category
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Course Belongs to many ages
     * @return BelongsToMany
     */
    public function ages(): BelongsToMany
    {
        return $this->belongsToMany(Age::class)
            ->withTimestamps();
    }

    /**
     * Course Has Many Booking
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * @return SEOData
     */
    public function getDynamicSEOData(): SEOData
    {
        $this->loadMissing('image');
        $media_links = collect($this->getRelation('image')?->getResponsiveImageUrls() ?? []);

        // Override only the properties you want:
        return new SEOData(
            title: $this->getAttribute('name'),
            description: $this->getAttribute('description'),
            author: config('app.name'),
            image: str_replace(config('app.url'), '', $media_links->last()),
            url: route('courses.show', ['course' => $this, 'name' => str($this->getAttribute('name'))->slug()])
        );
    }

}
