<?php

namespace App\Enums;

enum WithdrawalRequestStatus: string
{
    use EnumToArray;
    case PAID = 'paid';
    case DECLINED = 'declined';

    case PENDING = 'pending';
}
