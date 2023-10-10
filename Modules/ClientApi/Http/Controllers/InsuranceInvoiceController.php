<?php

namespace Modules\ClientApi\Http\Controllers;

use App\Enums\Cryptocurrency;
use App\Enums\Currency;
use App\Enums\InsuranceInvoiceStatus;
use App\Facades\Payments\CoinbasePayments;
use App\Facades\Payments\ShkeeperPayments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rules\Enum;
use Modules\ClientApi\Http\Resources\InsuranceInvoiceResource;
use Modules\ClientApi\Models\InsuranceCoverageOption;
use Modules\ClientApi\Models\InsuranceInvoice;
use Modules\ClientApi\Models\InsuranceOption;
use Modules\ClientApi\Models\InsurancePack;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;

class InsuranceInvoiceController extends BaseClientApiController
{
    public function show(InsuranceInvoice $insuranceInvoice): JsonResponse
    {
        return $this->respondSuccess(new InsuranceInvoiceResource($insuranceInvoice));
    }
    public function createCustom(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'insurance_options' => 'required|array',
            'insurance_options.*' => 'required|exists:insurance_options,id',
            'insurance_subscription_option_id' => 'required|exists:insurance_subscription_options,id',
            'insurance_coverage_option_id' => 'required|exists:insurance_coverage_options,id'
        ]);

        $subscriptionOption = InsuranceSubscriptionOption::find($validated['insurance_subscription_option_id']);
        $coverageOption = InsuranceCoverageOption::find($validated['insurance_coverage_option_id']);
        $summedPrice = InsuranceOption::whereIn('id', $validated['insurance_options'])->sum('price');
        $summedPrice = $subscriptionOption->calculatePrice($summedPrice);
        $summedPrice = $coverageOption->addToPrice($summedPrice);

        $insuranceInvoice = InsuranceInvoice::create([
            'amount' => $summedPrice,
            'currency' => Currency::USD,
            'user_id' => $request->user()->id,
            'insurance_subscription_option_id' => $validated['insurance_subscription_option_id'],
            'coverage' => $coverageOption->coverage,
            'status' => InsuranceInvoiceStatus::UNPAID,
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
        $subscriptionOption = InsuranceSubscriptionOption::find($validated['insurance_subscription_option_id']);

        $insuranceInvoice = InsuranceInvoice::create([
            'amount' => $subscriptionOption->calculatePrice($insurancePack->price),
            'coverage' => $insurancePack->coverage,
            'currency' => Currency::USD,
            'user_id' => $request->user()->id,
            'insurance_subscription_option_id' => $validated['insurance_subscription_option_id'],
            'status' => InsuranceInvoiceStatus::UNPAID,
        ]);

        $insuranceInvoice->options()->sync($insurancePack->options->pluck('id'));

        return $this->respondSuccess(new InsuranceInvoiceResource($insuranceInvoice));
    }

    public function createCoinbaseInvoice(InsuranceInvoice $insuranceInvoice): JsonResponse
    {
        $transactionUrl = App::make(CoinbasePayments::class)->createInvoice($insuranceInvoice);
        return $this->respondSuccess($transactionUrl);
    }

    public function createShkeeperTransaction(Request $request, InsuranceInvoice $insuranceInvoice): JsonResponse
    {
        $validated = $request->validate([
            'cryptocurrency' => ['required', new Enum(Cryptocurrency::class)],
        ]);

        $transaction = App::make(ShkeeperPayments::class)
            ->createShkeeperTransaction($insuranceInvoice, Cryptocurrency::from($validated['cryptocurrency']));

        return $this->respondSuccess([
            'currency' => $transaction->currency->value,
            'amount' => $transaction->amount,
            'wallet' => $transaction->wallet,
            'exchange_rate' > $transaction->exchangeRate,
        ]);
    }
}
