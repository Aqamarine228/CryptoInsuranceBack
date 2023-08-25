<?php

namespace App\Services\Shkeeper;

use App\Enums\Currency;

class ShkeeperTransaction
{

    public function __construct(
        public int    $id,
        public string $status,
        public float $amount,
        public string $exchangeRate,
        public string $wallet,
    ) {
    }
}
