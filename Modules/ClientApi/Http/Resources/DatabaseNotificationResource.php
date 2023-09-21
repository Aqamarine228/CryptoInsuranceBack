<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\DatabaseNotification;

/**
 * class DatabaseNotificationResource
 *
 * @mixin DatabaseNotification
 */
class DatabaseNotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'data' => $this->data,
            'created_at' => $this->created_at,
        ];
    }
}
