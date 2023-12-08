<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AgeCourse extends Pivot
{
    use HasFactory;

    protected $table = 'age_course';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'age_id',
    ];

    /**
     * AgeCourse Belongs to age
     * @return BelongsTo
     */
    public function age(): BelongsTo
    {
        return $this->belongsTo(Age::class);
    }

    /**
     * AgeCourse Belongs to course
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
