<?php

namespace App\Models;

use App\Traits\Attributes\HasPrimaryImage;
use App\Traits\Attributes\HasTranslatableWithJsonEscape;
use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class SocialMedia extends Model implements HasMedia
{
    use HasFactory, HasTranslatableWithJsonEscape, HasActiveScope, HasPrimaryImage;

    protected  bool $responsiveImagesEnabled = false;

    public $translatable = ['name'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'link',
        'is_active'
    ];

}
