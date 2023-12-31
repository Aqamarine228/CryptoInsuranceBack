<?php

namespace Modules\Admin\Models;

use App\Actions\GenerateFileName;
use App\Enums\ReferralRequestStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Exception;

class ReferralRequest extends \App\Models\ReferralRequest
{
    protected array $localizable = [];
    protected $fillable = ['approved_at', 'status', 'rejection_reason_en', 'rejection_reason_ru'];

    /**
     * Methods
     * @throws Exception
     */

    public static function getDocumentPath(string $filename): string
    {
        return 'kyc/' . $filename;
    }

    public static function getPendingCount(): int
    {
        return self::where('status', ReferralRequestStatus::PENDING)->count();
    }

    public function approve(): void
    {
        $this->update([
            'status' => ReferralRequestStatus::APPROVED,
            'approved_at' => now(),
        ]);
    }

    public function reject(array $reasons): void
    {
        $this->update([
            'status' => ReferralRequestStatus::REJECTED,
            ...$reasons,
        ]);
    }

    /**
     * Relations
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
