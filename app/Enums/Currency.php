<?php

namespace App\Enums;

enum Currency: string
{

    use EnumToArray;

    case USD = 'USD';

    case BTC = 'BTC';
    case DODGE = 'DODGE';
    case LTC = 'LTC';
    case USDC = 'USDC';
    case USDT = 'USDT';
    case TRX = 'TRX';
}
