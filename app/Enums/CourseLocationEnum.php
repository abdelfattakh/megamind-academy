<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;
/**
 * @method static self Online()
 * @method static self Offline()
 * @method static self Udemy()
 */
final class CourseLocationEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'Online' => __('Online'),
            'Offline' => __('Offline'),
            'Udemy' => __('Udemy'),
        ];
    }
}
