<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;
/**
 * @method static self Saturday()
 * @method static self Sunday()
 * @method static self Monday()
 * @method static self Tuesday()
 * @method static self Wednesday()
 * @method static self Thursday()
 * @method static self Friday()
 */
final class DaysEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'Saturday' => __('Saturday'),
            'Sunday' => __('Sunday'),
            'Monday' => __('Monday'),
            'Tuesday' => __('Tuesday'),
            'Wednesday' => __('Wednesday'),
            'Thursday' => __('Thursday'),
            'Friday' => __('Friday'),
        ];
    }
}
