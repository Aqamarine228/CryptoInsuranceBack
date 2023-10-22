<?php

namespace Modules\ClientApi\Models;

class InsuranceWallet extends \App\Models\InsuranceWallet
{

    protected $fillable = [
        'cryptocurrency', 'value',
    ];

}
