<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class StatisticsSettings extends Settings
{
    /**
     * training_hours.
     * @var string
     */
    public string $training_hours;

    /**
     * qualified_trainers.
     * @var string
     */
    public string $qualified_trainers;

    /**
     * classes_completed.
     * @var string
     */
    public string $classes_completed;

    /**
     * student_enrolled.
     * @var string
     */
    public string $student_enrolled;

    /**
     * participate_in_competition.
     * @var string
     */
    public string $participate_in_competition;

    /**
     * no_of_countries.
     * @var string
     */
    public string $no_of_countries;

    public static function group(): string
    {
        return 'statistics';
    }
    protected static function defaults(): array
    {
        return [
            'training_hours' => 'navigation_horizontal',
            'qualified_trainers' => 'navigation_horizontal',
            'classes_completed' => 'navigation_horizontal',
            'student_enrolled' => 'navigation_horizontal',
            'no_of_countries' => 'navigation_horizontal',
            'participate_in_competition' => 'navigation_horizontal',
        ];
    }
}
