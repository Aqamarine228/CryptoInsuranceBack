<?php

namespace App\Enums;

enum InsuranceInvoiceStatus: string
{
    use EnumToArray;
    case UNPAID = 'unpaid';
    case PAID = 'paid';
}
