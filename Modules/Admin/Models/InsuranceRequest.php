<?php

namespace Modules\Admin\Models;

use App\Enums\InsuranceRequestStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class InsuranceRequest extends \App\Models\InsuranceRequest
{

    protected $fillable = ['status', 'approved_at', 'rejection_reason_ru', 'rejection_reason_en'];

    /**
     * Scopes
     */

    public function scopePending(Builder $query)
    {
        $query->where('status', InsuranceRequestStatus::PENDING);
    }

    /**
     * Methods
     */

    public static function getPendingCount(): int
    {
        return self::where('status', InsuranceRequestStatus::PENDING)->count();
    }

    public function approve(): void
    {
        DB::transaction(function () {
            $this->update([
                'status' => InsuranceRequestStatus::APPROVED,
                'approved_at' => now(),
            ]);

            $this->user->update([
                'balance' => $this->user->balance += $this->coverage,
            ]);
        });
    }

    public function reject($reasons): void
    {
        $this->update([
            'status' => InsuranceRequestStatus::REJECTED,
            ...$reasons,
        ]);
    }

    /**
     * Relations
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(InsuranceOption::class, 'insurance_option_id');
    }

    public function fields(): HasMany
    {
        return $this->hasMany(InsuranceRequestField::class);
    }
}
