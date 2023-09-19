<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\ClientApi\Http\Resources\ReferralResource;

class ReferralsController extends BaseClientApiController
{
    const RECORDS_PER_PAGE_COUNT = 5;

    const FILTERABLE_COLUMNS = ['inviter_income_sum_amount'];

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'filterable_columns' => ['nullable', 'array'],
            'filterable_columns.*.name' => [Rule::in(self::FILTERABLE_COLUMNS)],
            'filterable_columns.*.order' => [Rule::in(['asc', 'desc'])]
        ]);

        return $this->respondSuccess(
            ReferralResource::collection(
                $request
                    ->user()
                    ->referrals()
                    ->with('latestInviterIncome')
                    ->withSum('inviterIncome', 'amount')
                    ->when(
                        array_key_exists('filterable_columns', $validated) && $validated['filterable_columns'],
                        fn($q) => $q->filterByColumns($validated['filterable_columns'])
                    )
                    ->paginate(self::RECORDS_PER_PAGE_COUNT)
            )->response()->getData(true)
        );
    }

    public function widgetsData(Request $request): JsonResponse
    {
        return $this->respondSuccess([
            'count' => $request->user()->referrals()->count(),
            'income_overall' => (float)$request->user()->referralIncome()->sum('amount'),
            'count_new_today' => $request->user()->referrals()->whereDate('created_at', today())->count(),
            'income_today' => $request->user()->referralIncome()->whereDate('created_at', today())->sum('amount'),
        ]);
    }

}
