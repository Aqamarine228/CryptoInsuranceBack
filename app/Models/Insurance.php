<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{

    protected $casts = [
        'expires_at' => 'datetime'
    ];
}
