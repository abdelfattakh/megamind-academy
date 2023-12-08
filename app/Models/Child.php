<?php

namespace App\Models;

use App\Traits\Attributes\HasPrimaryImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;

class Child extends Model implements HasMedia
{
    use HasFactory,HasPrimaryImage;

    protected $fillable = [
        'id',
        'name',
        'birthdate',
        'address',
        'phone',
        'phone_country',
    ];

    public function session_reviews(): HasMany
    {
        return $this->hasMany(ChildSessionReview::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function absent_sessions(): HasMany
    {
        return $this->session_reviews()->where('attendance', false);
    }

    public function attended_sessions(): HasMany
    {
        return $this->session_reviews()->where('attendance', true);
    }
}
