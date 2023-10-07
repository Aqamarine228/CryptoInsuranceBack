<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\ClientApi\Jobs\CreateInsuranceRequest;
use Modules\ClientApi\Jobs\CreateWithdrawalRequest;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule
            ->call(function () {
                $job = new CreateWithdrawalRequest();
                $job->delay(rand(0, 60 * 59));
                dispatch($job);
            })
            ->hourly();
        $schedule
            ->call(function () {
                $job = new CreateInsuranceRequest();
                $job->delay(rand(0, 60 * 59));
                dispatch($job);
            })
            ->hourly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
