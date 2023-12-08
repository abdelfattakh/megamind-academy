<?php

namespace App\Models;

use App\Traits\Attributes\HasTranslatableWithJsonEscape;
use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory, HasTranslatableWithJsonEscape, HasActiveScope;

    /**
     * The attributes that are Translatable.
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
        'is_active',
        'country_id',
    ];

    /**
     * City Belongs to Country
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
