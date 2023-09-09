<?php

namespace Modules\ClientApi\Models;

use App\Enums\ReferralRequestStatus;
use Exception;

class ReferralRequest extends \App\Models\ReferralRequest
{
    protected $fillable = [
        'user_id',
        'status',
        'telegram_account',
        'address',
        'document_photo',
    ];

    /**
     * Methods
     * @throws Exception
     */

    public static function getDocumentPath(string $filename): string
    {
        return 'kyc/' . $filename;
    }

    /**
     * Scopes
     */

    public function scopePending($q)
    {
        return $q->where('status', ReferralRequestStatus::PENDING);
    }
}
