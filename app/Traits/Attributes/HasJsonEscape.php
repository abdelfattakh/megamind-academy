<?php

namespace App\Traits\Attributes;

trait HasJsonEscape
{
    /**
     * Encode the given value as JSON.
     *
     * @param mixed $value
     * @return string
     */
    protected function asJson(mixed $value): string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
