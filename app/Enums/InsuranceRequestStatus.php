<?php

namespace App\Enums;

enum InsuranceRequestStatus: string
{

    use EnumToArray;

    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
