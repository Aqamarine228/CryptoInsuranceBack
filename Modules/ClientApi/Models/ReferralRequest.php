<?php

namespace Modules\ClientApi\Models;

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
}
