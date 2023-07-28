<?php

namespace App\Enums;

enum ReferralRequestStatus: string
{
    use EnumToArray;
    case APPROVED = 'approved';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
}
