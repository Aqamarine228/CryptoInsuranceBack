<?php

namespace App\Jobs\CoinbaseWebhooks;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Shakurov\Coinbase\Models\CoinbaseWebhookCall;

class Test implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private CoinbaseWebhookCall $webhookCall,
    ) {
    }

    public function handle(): void
    {
        dd($this->webhookCall);
    }
}
