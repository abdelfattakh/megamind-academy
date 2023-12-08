<?php

namespace App\Traits\Enum;

use Illuminate\Support\Str;

trait Label
{
    /**
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __(class_basename(self::$model));
    }

    /*
     * @return  string
     */
    public static function getPluralModelLabel(): string
    {
        return __(Str::plural(class_basename(self::$model)));
    }
}
