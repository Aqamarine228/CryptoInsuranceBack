<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetVariable extends Model
{

    public $timestamps = false;

    /**
     * Methods
     */

    public static function createRequired(): void
    {
        self::firstOrCreate([
            'name' => 'insurance_fund',
            'value' => 0,
        ]);

        self::firstOrCreate([
            'name' => 'total_insurance_paid',
            'value' => 0,
        ]);

        self::firstOrCreate([
            'name' => 'insurance_paid_today',
            'value' => 0,
        ]);
    }

    public static function getInsuranceFund(): self
    {
        return self::where('name', 'insurance_fund')->first();
    }

    public static function getTotalInsurancePaid(): self
    {
        return self::where('name', 'total_insurance_paid')->first();
    }

    public static function getInsurancePaidToday(): self
    {
        return self::where('name', 'insurance_paid_today')->first();
    }
}
