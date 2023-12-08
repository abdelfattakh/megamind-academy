<?php

namespace App\Models;

use App\Notifications\GeneralNotification;
use App\Traits\Attributes\HasJsonEscape;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Notification;

class ChildSessionReview extends Model
{
    use HasFactory;
    use HasJsonEscape;

    protected $fillable = [
        'session_entry_id',
        'child_id',
        'child_name',
        'data',
        'attendance',
    ];

    protected $casts = [
        'data' => 'array',
        'attendance' => 'bool',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function (self $model) {
            if ($model->getAttribute('child_id')) {
                $workShop = WorkshopEntry::query()
                    ->select('child_id', 'child_name')
                    ->where('child_id', $model->getAttribute('child_id'))
                    ->first();

                if (filled($workShop?->getAttribute('child_name')) && $workShop->getAttribute('child_name') != $model->getAttribute('child_name')) {
                    $model->update(['child_name' => $workShop->child_name]);
                }
            }
        });

        static::created(function (self $model) {
            // absent 2 times in level in course.
            $count = self::query()
                ->where(['child_id' => $model->getAttribute('child_id')])
                ->where(['attendance' => false])
                ->whereRelation('session_entry', 'course_id', $model->session_entry->course_id)
                ->whereRelation('session_entry', 'level_no', $model->session_entry->level_no)
                ->count();

            if ($count > 2) {
                $admins = Admin::query()
                    ->role('Customer Support')
                    ->select('id', 'phone')
                    ->get();

                $workShop = WorkshopEntry::query()
                    ->select('child_id', 'child_name')
                    ->where('child_id', $model->getAttribute('child_id'))
                    ->first();

                $childName = $model->getAttribute('child_name') ?? $workShop->getAttribute('child_name');

                Notification::send(
                    notifiables: $admins,
                    notification: new GeneralNotification(
                        title: '⚠️ Absent Alert | أندار غياب ⚠️',
                        body: "🙋 مرحبا ! \n" .
                        "للأسف الطالب #{$model->getAttribute('child_id')} {$childName}: \n" .
                        "🧑‍🏫 لقد قام/ت بالغياب " . $count . " مرات\n" .
                        "🙋‍♂️ أراك لاحقا عند حدوث خبر اخر",
                        methods: ['whatsapp', 'database'],
                    ),
                );
            }
        });
    }

    public function session_entry(): BelongsTo
    {
        return $this->belongsTo(SessionEntry::class);
    }
}
