<?php

namespace App\Models;

use App\Traits\Attributes\HasPrimaryImage;
use App\Traits\Attributes\HasTranslatableWithJsonEscape;
use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;

class Age extends Model implements HasMedia
{
    use HasFactory, HasActiveScope, HasTranslatableWithJsonEscape, HasPrimaryImage;

    /**
     * Media Collection
     */
    public static string $age_images = 'age_images';
    /**
     * The attributes that are translatable.
     *
     * @var array<int, string>
     */
    public $translatable = ['name', 'description'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    /**
     * Age Belongs to many courses
     * @return BelongsToMany
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)
            ->withTimestamps();
    }


}
