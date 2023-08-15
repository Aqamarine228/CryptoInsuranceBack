<?php

namespace App\Enums;

enum InsuranceOptionFieldType: string
{

    use EnumToArray, EnumToString;

    case NUMBER = 'number';
    case TEXT = 'text';
}
