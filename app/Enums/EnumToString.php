<?php

namespace App\Enums;

trait EnumToString
{
    public static function stringValues(): string
    {
        return implode(',', array_column(self::cases(), 'value'));
    }
}
