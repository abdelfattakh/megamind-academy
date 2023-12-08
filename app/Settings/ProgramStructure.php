<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ProgramStructure extends Settings
{
    /**
     * weekly_hours.
     * @var string
     */
    public string $weekly_hours;

    /**
     * age_range.
     * @var string
     */
    public string $age_range;

    /**
     * group_size.
     * @var string
     */
    public string $group_size;

    /**
     * languages.
     * @var string
     */
    public string $languages;

    /**
     * location.
     * @var string
     */
    public string $location;

    public static function group(): string
    {
        return 'structure';
    }
}
