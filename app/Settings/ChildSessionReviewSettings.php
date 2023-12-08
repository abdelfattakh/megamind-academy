<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ChildSessionReviewSettings extends Settings
{
    /**
     * student_enrolled.
     * @var string
     */
    public array $booleans;

    public array $ratings;

    public array $texts;

    public static function group(): string
    {
        return 'child_session_reviews';
    }

    protected static function defaults(): array
    {
        return [
            'booleans' => ['attendance'],
            'ratings' => ['homework'],
            'texts' => ['comment'],
        ];
    }
}
