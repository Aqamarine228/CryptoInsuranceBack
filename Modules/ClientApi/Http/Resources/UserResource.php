<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\User;

/**
 * class UserResource
 *
 * @mixin User
 */
class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => \Str::title($this->first_name),
            'last_name' => \Str::title($this->last_name),
            'referral_id' => $this->referral_id,
            'email' => $this->email,
            'email_verified' => (bool)$this->email_verified_at,
            'created_at' => $this->created_at,
            'has_referral_request' => $this->referralRequests()->pending()->exists(),
            'has_insurance' => $this->insurances()->active()->exists(),
        ];
    }

}
