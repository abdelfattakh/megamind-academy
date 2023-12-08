<?php

namespace App\Models;

use App\Enums\CourseLocationEnum;
use App\Enums\DaysEnum;
use App\Traits\Verify\CanChangeInternationalPhone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Propaganistas\LaravelPhone\Casts\RawPhoneNumberCast;

class Booking extends Model
{
    use HasFactory, CanChangeInternationalPhone;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'date_of_birth',

        'phone',
        'phone_country',
        'phone_normalized',
        'phone_national',
        'phone_e164',

        'country_id',
        'category_id',
        'subscription_id',
        'child_id',

        'location_of_course',
        'days',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'phone' => RawPhoneNumberCast::class,
        'date_of_birth' => 'datetime',
        'days' => DaysEnum::class . ':collection',
        'location_of_course' => CourseLocationEnum::class
    ];

    /**
     * Booking Belongs to country
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Booking Belongs to Category
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Booking Belongs to Child
     * @return BelongsTo
     */
    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }

    /**
     * Booking Belongs to Subscription
     * @return BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
