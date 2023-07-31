<?php

namespace App\Enums;

enum Currencies: string
{

    use EnumToArray;

    case USDT = 'usdt';
}
