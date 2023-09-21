<?php

namespace Modules\ClientApi\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\ClientApi\Models\DatabaseNotification;
use Modules\ClientApi\Models\User;

class DatabaseNotificationPolicy
{
    use HandlesAuthorization;

    public function show(User $user, DatabaseNotification $databaseNotification)
    {
        $user->notifications()->where('id', $databaseNotification->id)->exists();
    }

}
