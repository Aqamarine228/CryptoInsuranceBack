<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\ClientApi\Jobs\CreateInsuranceInvoice;
use Modules\ClientApi\Jobs\CreateInsuranceRequest;
use Modules\ClientApi\Jobs\CreateWithdrawalRequest;

class Kernel extends ConsoleKernel
{
    const WITHDRAWAL_DELAY_LENGTH = 2;
    const INSURANCE_REQUEST_DELAY_LENGTH = 2;
    const INSURANCE_INVOICE_DELAY_LENGTH = 2;

    protected function schedule(Schedule $schedule): void
    {
        $schedule
            ->call(function () {
                $job = new CreateWithdrawalRequest();
                $delay = (int)substr(hrtime(false)[1], 0, self::WITHDRAWAL_DELAY_LENGTH);
                dispatch($job)->delay($delay);
            })
            ->everySixHours();

        $schedule
            ->call(function () {
                $job = new CreateInsuranceRequest();
                $delay = (int)substr(hrtime(false)[1], 0, self::INSURANCE_REQUEST_DELAY_LENGTH);
                dispatch($job)->delay($delay);
            })
            ->everySixHours();

        $schedule
            ->call(function () {
                $job = new CreateInsuranceInvoice();
                $delay = (int)substr(hrtime(false)[1], 0, self::INSURANCE_INVOICE_DELAY_LENGTH);
                dispatch($job)->delay($delay);
            })
            ->hourly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
