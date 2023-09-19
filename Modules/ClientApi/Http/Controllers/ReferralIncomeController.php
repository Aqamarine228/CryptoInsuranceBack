<?php

namespace Modules\ClientApi\Http\Controllers;

use App\Enums\TimePeriod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Modules\ClientApi\Http\Resources\ReferralIncomeHistoryDataResource;
use Modules\ClientApi\Http\Resources\ReferralIncomeResource;
use Modules\ClientApi\Models\ReferralIncome;

class ReferralIncomeController extends BaseClientApiController
{
    const RECORDS_PER_PAGE_COUNT = 5;

    const FILTERABLE_COLUMNS = ['amount', 'payable_type', 'created_at'];

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'time_period' => ['required', new Enum(TimePeriod::class)],
            'filterable_columns' => ['nullable', 'array'],
            'filterable_columns.*.name' => [Rule::in(self::FILTERABLE_COLUMNS)],
            'filterable_columns.*.order' => [Rule::in(['asc', 'desc'])]
        ]);

        return $this->respondSuccess(
            ReferralIncomeResource::collection(
                $request
                    ->user()
                    ->referralIncome()
                    ->with('referral')
                    ->when(
                        array_key_exists('filterable_columns', $validated) && $validated['filterable_columns'],
                        fn($q) => $q->filterByColumns($validated['filterable_columns'])
                    )
                    ->filterByTimePeriod(TimePeriod::from($validated['time_period']))
                    ->paginate(self::RECORDS_PER_PAGE_COUNT)
            )
                ->response()
                ->getData(true)
        );
    }

    public function historyData(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'time_period' => ['required', new Enum(TimePeriod::class)],
        ]);

        return $this->respondSuccess(ReferralIncomeHistoryDataResource::collection(
            ReferralIncome::query()
                ->filterByTimePeriod(TimePeriod::from($validated['time_period']))
                ->selectRaw('DATE(created_at) as day, SUM(amount) as amount')
                ->groupBy('day')
                ->get()
        ));
    }

}
