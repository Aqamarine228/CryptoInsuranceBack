<?php

namespace App\Enums;

enum WithdrawalStatus: string
{
    use EnumToArray;
    case PAID = 'paid';
    case DECLINED = 'declined';

    case PENDING = 'pending';
}
