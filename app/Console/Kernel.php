<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\ClientApi\Jobs\CreateInsuranceInvoice;
use Modules\ClientApi\Jobs\CreateInsuranceRequest;
use Modules\ClientApi\Jobs\CreateWithdrawalRequest;

class Kernel extends ConsoleKernel
{
    const WITHDRAWAL_RANDOM_LENGTH = 16;
    const INSURANCE_REQUEST_RANDOM_LENGTH = 16;
    const INSURANCE_INVOICE_RANDOM_LENGTH = 4;

    const MAX_DELAY = 900;

    protected function schedule(Schedule $schedule): void
    {
        $schedule
            ->call(function () {
                $job = new CreateWithdrawalRequest();
                $delay = mt_rand(1, self::MAX_DELAY);
                if (mt_rand(1, self::WITHDRAWAL_RANDOM_LENGTH) === 1) {
                    dispatch($job)->delay($delay);
                }
            })
            ->everyFifteenMinutes();

        $schedule
            ->call(function () {
                $job = new CreateInsuranceRequest();
                $delay = mt_rand(1, self::MAX_DELAY);
                if (mt_rand(1, self::INSURANCE_REQUEST_RANDOM_LENGTH) === 1) {
                    dispatch($job)->delay($delay);
                }
            })
            ->everyFifteenMinutes();

        $schedule
            ->call(function () {
                $job = new CreateInsuranceInvoice();
                $delay = mt_rand(1, self::MAX_DELAY);
                if (mt_rand(1, self::INSURANCE_INVOICE_RANDOM_LENGTH) === 1) {
                    dispatch($job)->delay($delay);
                }
            })
            ->everyFifteenMinutes();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
