<?php

namespace App\Facades\Payments;

use App\Enums\Cryptocurrency;
use App\Enums\PaymentTransactionStatus;
use App\Models\Payable;
use App\Models\PaymentTransaction;
use App\Services\Shkeeper\Shkeeper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Payments
{

    private Shkeeper $shkeeper;

    public function __construct()
    {
        $this->shkeeper = new Shkeeper(config('services.shkeeper.api_key'));
    }

    public function createShkeeperTransaction(Payable $payable, Cryptocurrency $cryptocurrency): CryptoTransaction
    {
        $id = Str::uuid();
        $transaction = DB::transaction(function () use ($id, $payable, $cryptocurrency) {
            Model::unguarded(fn () => PaymentTransaction::create([
                'uuid' => $id,
                'currency' => $payable->getCurrency(),
                'amount' => $payable->getPrice(),
                'status' => PaymentTransactionStatus::UNPAID,
                'payable_type' => get_class($payable),
                'payable_id' => $payable->getId(),
                'user_id' => $payable->getUserId(),
            ]));
            return $this->shkeeper->createTransaction(
                $id,
                $payable->getCurrency(),
                $cryptocurrency,
                $payable->getPrice(),
                route(config('services.shkeeper.callback_url')),
            );
        });

        return new CryptoTransaction(
            currency: $cryptocurrency,
            amount: $transaction->amount,
            wallet: $transaction->wallet,
            exchangeRate: $transaction->exchangeRate
        );
    }
}
