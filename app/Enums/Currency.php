<?php

namespace App\Enums;

enum Currency: string
{

    use EnumToArray;

    case USD = 'USD';
}
