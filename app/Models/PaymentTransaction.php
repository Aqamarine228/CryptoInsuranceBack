<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PaymentTransaction extends Model
{

    /**
     * Relations
     */

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }
}
