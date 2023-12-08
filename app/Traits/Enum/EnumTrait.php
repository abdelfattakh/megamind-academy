<?php

namespace App\Traits\Enum;

trait EnumTrait
{

    /**
     * @return array
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * @return array
     */
    public static function toValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return array
     */
    public static function toNames(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * @return array
     */
    public static function translated(): array
    {
        $translatedEnums = [];
        foreach (self::cases() as $case) {
            $translatedEnums[($case->value)] =__($case->value);
        }
        return $translatedEnums;
    }

}
