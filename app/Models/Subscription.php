<?php

namespace App\Models;

use App\Traits\Attributes\HasTranslatableWithJsonEscape;
use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    use HasActiveScope;
    use HasTranslatableWithJsonEscape;

    /**
     * The attributes that are translatable.
     *
     * @var array<int, string>
     */
    public $translatable = ['name', 'currency', 'benefits'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'currency',
        'benefits',
        'is_active',
        'discount_price'
    ];
}
