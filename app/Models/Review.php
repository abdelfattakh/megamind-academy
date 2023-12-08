<?php

namespace App\Models;

use App\Traits\Attributes\HasPrimaryImage;
use App\Traits\Attributes\HasTranslatableWithJsonEscape;
use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class Review extends Model implements HasMedia
{
    use HasFactory, HasPrimaryImage, HasActiveScope;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'comment',
        'is_active'

    ];

}
