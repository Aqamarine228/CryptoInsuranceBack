<?php

namespace App\Enums;

enum TimePeriod: string
{
    case TODAY = 'today';
    case WEEK = 'week';
    case MONTH = 'month';
    case YEAR = 'year';

}
