<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Modules\ClientApi\Http\Resources\InsuranceRecentActivityResource;
use Modules\ClientApi\Http\Resources\WithdrawalRequestRecentActivityResource;
use Modules\ClientApi\Models\InsuranceRequest;
use Modules\ClientApi\Models\WithdrawalRequest;

class DashboardController extends BaseClientApiController
{
    const RECENT_ACTIVITY_PER_PAGE_COUNT = 9;

    public function recentActivity(): JsonResponse
    {
        $insuranceRequests = InsuranceRecentActivityResource::collection(
            InsuranceRequest::approved()
                ->with('option')
                ->latest()
                ->limit(10)
                ->get()
        );

        $withdrawalRequests = WithdrawalRequestRecentActivityResource::collection(
            WithdrawalRequest::paid()->latest()->limit(10)->get()
        );

        $collection = new Collection();
        $collection = $collection->concat($insuranceRequests)->concat($withdrawalRequests);


        return $this->respondSuccess(
            $collection
            ->sortByDesc(fn ($col) => $col->created_at)
            ->take(self::RECENT_ACTIVITY_PER_PAGE_COUNT)
            ->flatten()
        );
    }
}
