<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Http\Resources\ReferralIncomeResource;
use Modules\ClientApi\Models\ReferralIncome;
use RuntimeException;

class ReferralIncomeController extends BaseClientApiController
{

    public function index(Request $request): JsonResponse
    {
        return $this->respondSuccess(
            ReferralIncomeResource::collection($request->user()->referralIncome()->paginate())
                ->response()
                ->getData(true)
        );
    }

    public function historyData(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'time_period' => 'required|string|in:day,week,month,year',
        ]);

        $query = ReferralIncome::query();

        $query = match ($validated['time_period']) {
            'day' => $query->whereDate('created_at', today()),
            'week' => $query->whereDate('created_at', '>', now()->subWeek()),
            'month' => $query->whereDate('created_at', '>', now()->subMonth()),
            'year' => $query->whereDate('created_at', '>', now()->subYear()),
            default => throw new RuntimeException('Invalid time period'),
        };

        return $this->respondSuccess($query->get()->pluck('amount', 'created_at'));
    }

}
