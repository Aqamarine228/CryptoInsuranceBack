<?php

namespace App\Facades\Payments;

use App\Enums\Cryptocurrency;

class CryptoTransaction
{
    public function __construct(
        public Cryptocurrency $currency,
        public float $amount,
        public string $wallet,
        public float $exchangeRate
    ) {
    }
}
