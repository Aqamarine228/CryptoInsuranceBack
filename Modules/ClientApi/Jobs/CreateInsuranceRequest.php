<?php

namespace Modules\ClientApi\Jobs;

use App\Enums\InsuranceRequestStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\ClientApi\Models\InsuranceCoverageOption;
use Modules\ClientApi\Models\InsuranceOption;
use Modules\ClientApi\Models\InsuranceRequest;
use Modules\ClientApi\Models\User;

class CreateInsuranceRequest implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $insuranceOption = InsuranceOption::inRandomOrder()->first();
        if (!$insuranceOption) {
            return;
        }
        $coverage = InsuranceCoverageOption::all()->pluck('coverage', 'id')->random();
        if (!$coverage) {
            return;
        }
        InsuranceRequest::create([
            'coverage' => $coverage,
            'insurance_option_id' => $insuranceOption->id,
            'approved_at' => now(),
            'status' => InsuranceRequestStatus::APPROVED->value,
            'user_id' => User::firstOrCreate(config('generators.user'), ['password' => '123'])->id,
        ]);
    }
}
