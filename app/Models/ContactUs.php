<?php

namespace App\Models;

use App\Traits\Verify\CanChangeInternationalPhone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelPhone\Casts\RawPhoneNumberCast;

class ContactUs extends Model
{
    use HasFactory, CanChangeInternationalPhone;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'message',
        'phone',
        'phone_country',
        'phone_normalized',
        'phone_national',
        'phone_e164',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'phone' => RawPhoneNumberCast::class,

    ];

}
