<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkshopEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        // Course Data.
        'course_id',
        'course_name',
        'level_no',
        'day',
        'finish_date',
        'start_date',
        'time',

        // Instructor Data.
        'instructor_id',
        'instructor_name',

        // Child Data.
        'child_id',
        'child_name',
        'child_phone_e164',

        // Status.
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'finish_date' => 'datetime',
        'start_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (self $model) {
            if (!filled($model->getAttribute('instructor_id'))) return;
            $admin = Admin::query()->select('name')->find($model->getAttribute('instructor_id'));
            if (!filled($admin)) return;
            $model->setAttribute('instructor_name', $admin->getAttribute('name'));
        });
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'instructor_id');
    }
}
