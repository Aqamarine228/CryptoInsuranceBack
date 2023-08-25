<?php

namespace App\Services\Shkeeper;

use App\Enums\Cryptocurrency;
use App\Enums\Currency;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Shkeeper
{
    private string $apiKey;
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function createTransaction(
        string   $externalId,
        Currency $fiat,
        Cryptocurrency $cryptocurrency,
        float    $amount,
        string   $callbackUrl,
    ): ShkeeperTransaction {
        $response = $this
            ->buildRequest()
            ->post($this->buildUrl('') . "/$cryptocurrency->value/payment_request", [
                'external_id' => $externalId,
                'fiat' => $fiat,
                'amount' => $amount,
                'callback_url' => $callbackUrl,
            ])
            ->json();
        return new ShkeeperTransaction(
            id: $response['id'],
            status: $response['status'],
            amount: $response['amount'],
            exchangeRate: $response['exchange_rate'],
            wallet: $response['wallet'],
        );
    }

    private function buildRequest(): PendingRequest
    {
        return Http::throw()->withHeaders([
            'X-Shkeeper-API-Key' => $this->apiKey,
        ]);
    }

    private function buildUrl(string $path): string
    {
        return config('services.shkeeper.url') . "/api/v1/" . $path;
    }
}
