<?php

namespace Modules\ClientApi\Models;

class InsuranceRequestField extends \App\Models\InsuranceRequestField
{
    protected $fillable = [
        'insurance_option_field_id',
        'insurance_request_id',
        'value',
    ];
}
