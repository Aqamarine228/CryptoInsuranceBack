<?php

namespace App\Actions;

use App\Enums\Cryptocurrency;
use Illuminate\Support\Facades\Http;

class GetCryptocurrencyPrice
{
    public static function execute(string $symbol): float
    {
        if (in_array($symbol, [Cryptocurrency::USDT->value, Cryptocurrency::USDC->value])) {
            return 1;
        }
        return Http::get("https://api.binance.com/api/v3/ticker/price?symbol={$symbol}USDT")->json()['price'];
    }
}
