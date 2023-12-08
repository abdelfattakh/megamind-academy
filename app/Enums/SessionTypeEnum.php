<?php

namespace App\Enums;


use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self Normal()
 * @method static self Compensatory()
 * @method static self Training()
 */
final class SessionTypeEnum extends Enum
{
    /**
     * @return string[]|Closure
     * @psalm-return array<string, string> | Closure(string):string
     */
    protected static function labels(): Closure|array
    {
        return function (string $name): string|int {
            return __('admin.' . str($name)->lower());
        };
    }
}


