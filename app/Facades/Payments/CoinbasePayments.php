<?php

namespace App\Facades\Payments;

use App\Enums\Currency;
use App\Enums\PaymentTransactionStatus;
use App\Models\Payable;
use App\Models\PaymentTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;
use Shakurov\Coinbase\Coinbase;

class CoinbasePayments
{
    private Coinbase $coinbase;

    public function __construct()
    {
        $this->coinbase = new Coinbase();
    }

    public function createInvoice(Payable $payable): string
    {
        return DB::transaction(function () use ($payable) {
            $user = User::find($payable->getUserId());
            $invoice = $this->coinbase->createInvoice([
                'business_name' => Str::title(config('client.company_name')),
                'customer_email' => $user->email,
                'customer_name' => "$user->first_name $user->last_name",
                'local_price' => [
                    'currency' => $this->payableCurrencyToCoinbase($payable->getCurrency()),
                    'amount' => $payable->getPrice(),
                ],
                'memo' => '',
            ]);

            Model::unguarded(fn () => PaymentTransaction::create([
                'uuid' => $invoice['data']['id'],
                'currency' => $payable->getCurrency(),
                'amount' => $payable->getPrice(),
                'status' => PaymentTransactionStatus::UNPAID,
                'payable_type' => get_class($payable),
                'payable_id' => $payable->getId(),
                'user_id' => $payable->getUserId(),
            ]));

            return $invoice['data']['hosted_url'];
        });
    }

    private function payableCurrencyToCoinbase(Currency $currency): string
    {
        return match ($currency->value) {
            Currency::USD->value => 'USD',
            default => throw new RuntimeException("Unsupported currency"),
        };
    }

}
