<?php

namespace App\Enums;

enum PaymentTransactionStatus: string
{
    use EnumToArray;
    case PAID = 'paid';
    case UNPAID = 'unpaid';
}
