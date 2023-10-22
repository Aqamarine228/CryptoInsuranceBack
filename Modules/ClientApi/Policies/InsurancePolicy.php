<?php

namespace Modules\ClientApi\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\ClientApi\Models\Insurance;
use Modules\ClientApi\Models\User;

class InsurancePolicy
{
    use HandlesAuthorization;

    public function show(User $user, Insurance $insurance): bool
    {
        return $user
            ->insurances()
            ->where('id', $insurance->id)
            ->exists();
    }

    public function storeInformation(User $user, Insurance $insurance): bool
    {
        return $user
            ->insurances()
            ->where('id', $insurance->id)
            ->exists();
    }
}
