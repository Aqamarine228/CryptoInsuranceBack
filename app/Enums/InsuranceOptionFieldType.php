<?php

namespace App\Enums;

enum InsuranceOptionFieldType: string
{

    use EnumToArray;

    case NUMBER = 'number';
    case TEXT = 'text';
}
