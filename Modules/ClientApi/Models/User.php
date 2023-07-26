<?php

namespace Modules\ClientApi\Models;

use Modules\ClientApi\Notifications\VerifyEmail;

class User extends \App\Models\User
{

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'inviter_id',
    ];

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail);
    }
}
