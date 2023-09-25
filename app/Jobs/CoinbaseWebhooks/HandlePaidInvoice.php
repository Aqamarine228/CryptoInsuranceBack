<?php

namespace App\Jobs\CoinbaseWebhooks;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\ClientApi\Models\PaymentTransaction;
use Shakurov\Coinbase\Models\CoinbaseWebhookCall;

class HandlePaidInvoice implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private CoinbaseWebhookCall $webhookCall,
    ) {
    }

    public function handle(): void
    {
        PaymentTransaction::where('uuid', $this->webhookCall->payload['event']['data']['id'])->first()->payable->paid();
    }
}
