<?php

namespace App\Enums;

enum InsuranceInformationType: string
{
    use EnumToArray;
    case EXCHANGE_NAME = 'exchange_name';
    case EXCHANGE_ID = 'exchange_id';
    case WALLET = 'wallet';
}
