<?php

namespace App\Settings;

use App\Traits\Attributes\HasPrimaryImage;
use Spatie\LaravelSettings\Settings;
use Spatie\MediaLibrary\HasMedia;

class JoinUsSettings extends Settings
{

    /**
     * Name.
     * @var string
     */
    public string $name;


    /**
     * Description.
     * @var string
     */
    public string $description;

    public static function group(): string
    {
        return 'join_us';
    }
    protected static function defaults(): array
    {
        return [
            'name' => 'navigation_horizontal',

        ];
    }
}
