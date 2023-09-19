<?php

namespace App\Models;

use App\Enums\TimePeriod;
use RuntimeException;

trait FilterableByTimePeriod
{

    public function scopeFilterByTimePeriod($q, TimePeriod $timePeriod)
    {
        return match ($timePeriod->value) {
            TimePeriod::TODAY->value => $q->whereDate('created_at', today()),
            TimePeriod::WEEK->value => $q->whereDate('created_at', '>', now()->subWeek()),
            TimePeriod::MONTH->value => $q->whereDate('created_at', '>', now()->subMonth()),
            TimePeriod::YEAR->value => $q->whereDate('created_at', '>', now()->subYear()),
            default => throw new RuntimeException('Invalid time period'),
        };
    }

}
