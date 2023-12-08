<?php

namespace App\Models;

use App\Enums\SessionTypeEnum;
use App\Filament\Resources\SessionEntryResource;
use App\Notifications\GeneralNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Notification;

class SessionEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        // Instructor Data.
        'instructor_id',
        'instructor_name',

        // Course Data.
        'course_id',

        // Session Data.
        'doc_date',
        'session_type',
        'session_no',
        'level_no',
        'is_level_finished',
        'comment',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'doc_date' => 'datetime',
        'session_type' => SessionTypeEnum::class . ':nullable',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function (self $model) {
            if ($model->getAttribute('is_level_finished')) {
                $model->loadMissing('instructor');
                $admins = Admin::query()
                    ->role(config('filament-shield.super_admin.name'))
                    ->select('id', 'phone')
                    ->get();

                Notification::send(
                    notifiables: $admins,
                    notification: new GeneralNotification(
                        title: '✅ Level Done | انتهاء المستوي ✅',
                        body: "🙋 مرحبا يا مدير ! \n" .
                        "احب أبلغك بكل سعادة بالتالي: \n" .
                        "🧑‍🏫 لقد قام/ت " . $model->getRelation('instructor')->name . "\n" .
                        "🎚️ بإكمال المستوي " . $model->getAttribute('level_no') . "\n" .
                        "📚 في الدورة " . $model->getAttribute('course_id') . "\n" .
                        "📅 باليوم " . $model->getAttribute('doc_date')?->locale('ar_SA')?->translatedFormat('d, F, Y') . "\n" .
                        "🔗 رابط التسجيل :" . SessionEntryResource::getUrl('view', ['record' => $model]) . "\n" .
                        "🙋‍♂️ أراك لاحقا عند حدوث خبر سعيد اخر",
                        methods: ['whatsapp', 'database'],
                    ),
                );
            }
        });
    }

    /**
     * Session Entry belongs to instructor
     * @return BelongsTo
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'instructor_id');
    }


    /**
     * Session Entry belongs to course
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');


    }

    /**
     * Workshop Entry
     * @return HasOne
     */
    public function work_shop(): HasOne
    {
        return $this->hasMany(WorkshopEntry::class, 'course_id', 'course_id')->one();
    }

    /**
     * Child Reviews
     * @return HasMany
     */
    public function child_session_reviews(): HasMany
    {
        return $this->hasMany(ChildSessionReview::class);
    }
}
