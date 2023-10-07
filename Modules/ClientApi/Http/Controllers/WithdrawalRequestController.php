<?php

namespace Modules\ClientApi\Http\Controllers;

use App\Actions\GetCryptocurrencyPrice;
use App\Enums\Cryptocurrency;
use App\Enums\Currency;
use App\Enums\TimePeriod;
use App\Enums\WithdrawalRequestStatus;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Modules\ClientApi\Http\Resources\WithdrawalRequestResource;

class WithdrawalRequestController extends BaseClientApiController
{
    private const FILTERABLE_COLUMNS = ['created_at', 'amount', 'crypto_amount'];
    private const RECORDS_PER_PAGE_COUNT = 15;

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'time_period' => ['required', new Enum(TimePeriod::class)],
            'filterable_columns' => ['nullable', 'array'],
            'filterable_columns.*.name' => [Rule::in(self::FILTERABLE_COLUMNS)],
            'filterable_columns.*.order' => [Rule::in(['asc', 'desc'])]
        ]);

        $withdrawalRequests = $request
            ->user()
            ->withdrawalRequests()
            ->when(
                array_key_exists('filterable_columns', $validated) && $validated['filterable_columns'],
                fn ($q) => $q->filterByColumns($validated['filterable_columns'])
            )
            ->filterByTimePeriod(TimePeriod::from($validated['time_period']))
            ->paginate(self::RECORDS_PER_PAGE_COUNT);

        return $this->respondSuccess(
            WithdrawalRequestResource::collection($withdrawalRequests)
                ->response()
                ->getData(true)
        );
    }

    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', "max:{$request->user()->balance}", "min:10"],
            'address' => ['required', 'string', 'max:255'],
            'cryptocurrency' => ['required', new Enum(Cryptocurrency::class)],
        ]);
        DB::transaction(function () use ($request, $validated) {
            $request->user()->withdrawalRequests()->create([
                'amount' => $validated['amount'],
                'cryptocurrency' => $validated['cryptocurrency'],
                'status' => WithdrawalRequestStatus::PENDING->value,
                'currency' => Currency::USD->value,
                'address' => $validated['address'],
                'crypto_amount' => bcdiv(
                    $validated['amount'],
                    GetCryptocurrencyPrice::execute($validated['cryptocurrency']),
                    8
                ),
            ]);
            $request->user()->update([
                'balance' => bcsub($request->user()->balance, $validated['amount'], 2),
            ]);
        });
        return $this->respondSuccess("Withdrawal Request Created Successfully");
    }
}
