<?php

namespace App\Facades\Payments;

use App\Enums\Cryptocurrency;

class ShkeeperCryptoTransaction
{
    public function __construct(
        public Cryptocurrency $currency,
        public float $amount,
        public string $wallet,
        public float $exchangeRate
    ) {
    }
}
