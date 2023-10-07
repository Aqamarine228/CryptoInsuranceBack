<?php

namespace Modules\ClientApi\Jobs;

use App\Actions\GetCryptocurrencyPrice;
use App\Enums\Cryptocurrency;
use App\Enums\Currency;
use App\Enums\WithdrawalRequestStatus;
use Faker\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Modules\ClientApi\Models\User;
use Modules\ClientApi\Models\WithdrawalRequest;
use Str;

class CreateWithdrawalRequest implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $cryptocurrency = array_rand(Cryptocurrency::array());
        $faker = Factory::create();
        $amount = $faker->randomNumber(7, false);
        $cryptoAmount = $this->getCurrencyAmount($amount, $cryptocurrency);
        WithdrawalRequest::create([
            'amount' => $amount,
            'address' => Str::uuid(),
            'cryptocurrency' => $cryptocurrency,
            'crypto_amount' => $cryptoAmount,
            'currency' => Currency::USD->value,
            'status' => WithdrawalRequestStatus::PAID->value,
            'user_id' => User::firstOrCreate(config('generators.user'), ['password' => '123'])->id,
        ]);
    }

    public function getCurrencyAmount(int $price, string $symbol): float
    {
        $currencyPrice = GetCryptocurrencyPrice::execute($symbol);
        return (float)bcdiv($price, $currencyPrice, 8);
    }
}
