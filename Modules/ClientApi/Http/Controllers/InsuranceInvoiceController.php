<?php

namespace Modules\ClientApi\Http\Controllers;

use App\Enums\Cryptocurrency;
use App\Enums\Currency;
use App\Facades\Payments\Payments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rules\Enum;
use Modules\ClientApi\Http\Resources\InsuranceInvoiceResource;
use Modules\ClientApi\Models\InsuranceInvoice;
use Modules\ClientApi\Models\InsuranceOption;
use Modules\ClientApi\Models\InsurancePack;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;

class InsuranceInvoiceController extends BaseClientApiController
{
    public function createCustom(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'insurance_options' => 'required|array',
            'insurance_options.*' => 'required|exists:insurance_options,id',
            'insurance_subscription_option_id' => 'required|exists:insurance_subscription_options,id',
        ]);

        $summedPrice = InsuranceOption::whereIn('id', $validated['insurance_options'])->sum('price');
        $price = $this->calculatePrice(
            $summedPrice,
            InsuranceSubscriptionOption::find($validated['insurance_subscription_option_id'])->sale_percentage
        );

        $insuranceInvoice = InsuranceInvoice::create([
            'amount' => $price,
            'currency' => Currency::USD,
            'user_id' => $request->user()->id,
            'insurance_subscription_option_id' => $validated['insurance_subscription_option_id'],
        ]);

        $insuranceInvoice->options()->sync($validated['insurance_options']);

        return $this->respondSuccess(new InsuranceInvoiceResource($insuranceInvoice));
    }

    public function createFromPack(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'insurance_subscription_option_id' => 'required|exists:insurance_subscription_options,id',
            'insurance_pack_id' => 'required|exists:insurance_packs,id',
        ]);

        $insurancePack = InsurancePack::find($validated['insurance_pack_id']);

        $price = $this->calculatePrice(
            $insurancePack->price,
            InsuranceSubscriptionOption::find($validated['insurance_subscription_option_id'])->sale_percentage
        );

        $insuranceInvoice = InsuranceInvoice::create([
            'amount' => $price,
            'currency' => Currency::USD,
            'user_id' => $request->user()->id,
            'insurance_subscription_option_id' => $validated['insurance_subscription_option_id'],
        ]);

        $insuranceInvoice->options()->sync($insurancePack->options->pluck('id'));

        return $this->respondSuccess(new InsuranceInvoiceResource($insuranceInvoice));
    }

    public function createShkeeperTransaction(Request $request, InsuranceInvoice $insuranceInvoice): JsonResponse
    {
        $validated = $request->validate([
            'cryptocurrency' => ['required', new Enum(Cryptocurrency::class)],
        ]);

        $transaction = App::make(Payments::class)
            ->createShkeeperTransaction($insuranceInvoice, Cryptocurrency::from($validated['cryptocurrency']));

        return $this->respondSuccess([
            'currency' => $transaction->currency->value,
            'amount' => $transaction->amount,
            'wallet' => $transaction->wallet,
            'exchange_rate' > $transaction->exchangeRate,
        ]);
    }

    private function calculatePrice(float $price, float $salePercentage): float
    {
        return (float)bcmul($price, bcdiv($salePercentage, "100", 2), 2);
    }
}
