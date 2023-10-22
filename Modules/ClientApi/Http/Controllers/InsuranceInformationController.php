<?php

namespace Modules\ClientApi\Http\Controllers;

use App\Enums\InsuranceInformationType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Models\Insurance;

class InsuranceInformationController extends BaseClientApiController
{

    public function store(Request $request, Insurance $insurance): JsonResponse
    {

        $validated = $request->validate([
            'exchange_id' => 'string|max:255',
            'exchange_name' => 'string|max:255',
            'wallets' => ['array', "max:$insurance->max_wallets_count"],
        ]);

        $toCreate = [];

        if (array_key_exists('wallets', $validated)) {
            foreach ($validated['wallets'] as $wallet) {
                $toCreate[] = [
                    'value' => $wallet,
                    'type' => InsuranceInformationType::WALLET->value,
                ];
            }
        }

        if (array_key_exists('exchange_id', $validated)) {
            if ($insurance->information->where('type', InsuranceInformationType::EXCHANGE_ID->value)->exists()) {
                return $this->respondErrorMessage('Exchange ID already filled');
            }
            $toCreate[] = ['type' => InsuranceInformationType::EXCHANGE_ID->value, 'value' => $validated['exchange_id']];
        }

        if (array_key_exists('exchange_name', $validated)) {
            $toCreate[] = ['type' => InsuranceInformationType::EXCHANGE_NAME->value, 'value' => $validated['exchange_name']];
        }

        $insurance->information()->createMany($toCreate);

        return $this->respondSuccess('Insurance information added successfully');
    }
}
