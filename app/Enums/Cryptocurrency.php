<?php

namespace App\Enums;

enum Cryptocurrency: string
{
    use EnumToArray;

    case BTC = 'BTC';
    case DODGE = 'DODGE';
    case LTC = 'LTC';
    case USDC = 'USDC';
    case USDT = 'USDT';
    case TRX = 'TRX';
}
