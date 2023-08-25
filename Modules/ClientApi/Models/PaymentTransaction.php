<?php

namespace Modules\ClientApi\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

class PaymentTransaction extends \App\Models\PaymentTransaction
{

    protected $fillable = [
        'status'
    ];

    /**
     * Relations
     */

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }
}
