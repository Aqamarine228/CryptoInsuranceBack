<?php

namespace Modules\ClientApi\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\ClientApi\Models\InsuranceOption;
use Modules\ClientApi\Models\User;

class InsuranceRequestPolicy
{
    use HandlesAuthorization;

    public function create(User $user, InsuranceOption $insuranceOption): bool
    {
        return $user
            ->insurances()
            ->active()
            ->whereHas('options', fn ($q) => $q->where('insurance_options.id', $insuranceOption->id))
            ->exists();
    }
}
