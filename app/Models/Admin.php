<?php

namespace App\Models;

use App\Contracts\Verify\MustVerifyPhone;
use App\Enums\SessionTypeEnum;
use App\Traits\Verify\CanChangeInternationalPhone;
use App\Traits\Verify\MustVerifyPhone as MustVerifyPhoneTrait;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use JeffGreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use ProtoneMedia\LaravelVerifyNewEmail\MustVerifyNewEmail;
use Spatie\Permission\Traits\HasRoles;


class Admin extends Authenticatable implements MustVerifyEmail, MustVerifyPhone, FilamentUser
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use TwoFactorAuthenticatable;
    use MustVerifyNewEmail;
    use MustVerifyPhoneTrait;
    use CanChangeInternationalPhone;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'phone',
        'phone_country',
        'phone_normalized',
        'phone_national',
        'phone_e164',
        'phone_verified_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    /**
     * return if this model can access filament
     * @return bool
     */
    public function canAccessFilament(): bool
    {
        return true;
    }

    public function workshop_entries(): HasMany
    {
        return $this->hasMany(WorkshopEntry::class, 'instructor_id');
    }

    public function session_entries(): HasMany
    {
        return $this->hasMany(SessionEntry::class, 'instructor_id');
    }

    public function normal_session_entries(): HasMany
    {
        return $this->session_entries()
            ->where('session_type', SessionTypeEnum::Normal());
    }

    public function compensatory_session_entries(): HasMany
    {
        return $this->session_entries()
            ->where('session_type', SessionTypeEnum::Compensatory());
    }

    public function level_finished_session_entries(): HasMany
    {
        return $this->session_entries()
            ->where('is_level_finished', true);
    }

    public function canImpersonate(): bool
    {
        return !$this->hasRole('super-admin');
    }
}
