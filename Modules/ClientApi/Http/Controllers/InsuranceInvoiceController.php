<?php

namespace Modules\ClientApi\Http\Controllers;

use App\Enums\Cryptocurrency;
use App\Enums\Currency;
use App\Enums\InsuranceInvoiceStatus;
use App\Facades\Payments\CoinbasePayments;
use App\Facades\Payments\ShkeeperPayments;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;
use Modules\ClientApi\Http\Resources\InsuranceInvoiceResource;
use Modules\ClientApi\Models\Insurance;
use Modules\ClientApi\Models\InsuranceCoverageOption;
use Modules\ClientApi\Models\InsuranceInvoice;
use Modules\ClientApi\Models\InsuranceOption;
use Modules\ClientApi\Models\InsurancePack;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;
use Modules\ClientApi\Models\User;

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
            'insurance_coverage_option_id' => 'required|exists:insurance_coverage_options,id',
        ]);


        $insuranceOptions = InsuranceOption::whereIn('id', $validated['insurance_options'])->get();
        $subscriptionOption = InsuranceSubscriptionOption::find($validated['insurance_subscription_option_id']);
        $coverageOption = InsuranceCoverageOption::find($validated['insurance_coverage_option_id']);
        $summedPrice = $insuranceOptions->sum('price');
        $summedPrice = $subscriptionOption->calculatePrice($summedPrice);
        $summedPrice = $coverageOption->addToPrice($summedPrice);

        $insuranceInvoice = DB::transaction(fn () => $this->createInvoice(
            $request->user(),
            $subscriptionOption,
            $insuranceOptions,
            $coverageOption->coverage,
            $summedPrice,
        ));

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

        $insuranceInvoice = DB::transaction(fn () => $this->createInvoice(
            $request->user(),
            $subscriptionOption,
            $insurancePack->options,
            $insurancePack->coverage,
            $subscriptionOption->calculatePrice($insurancePack->price)
        ));

        return $this->respondSuccess(new InsuranceInvoiceResource($insuranceInvoice));
    }

    private function createInvoice(
        User                        $user,
        InsuranceSubscriptionOption $subscriptionOption,
        Collection                  $options,
        int                         $coverage,
        float                       $price,
    ): InsuranceInvoice {
        $insurance = Insurance::create([
            'user_id' => $user->id,
            'expires_at' => now(),
            'coverage' => $coverage,
        ]);

        $insurance->options()->sync($options->pluck('id'));

        return InsuranceInvoice::create([
            'amount' => $price,
            'currency' => Currency::USD,
            'user_id' => $user->id,
            'insurance_id' => $insurance->id,
            'insurance_subscription_option_id' => $subscriptionOption->id,
            'coverage' => $coverage,
            'status' => InsuranceInvoiceStatus::UNPAID,
        ]);
    }

    public function createCoinbaseInvoice(Request $request, InsuranceInvoice $insuranceInvoice): JsonResponse
    {
        $validated = $request->validate([
            'exchange_id' => 'required|string|max:255',
            'exchange_name' => 'required|string|max:255',
            'wallets' => ['required', 'array', "max:{$insuranceInvoice->insurance->max_wallets_count}"],
            'wallets.*.value' => 'required|string|max:255',
            'wallets.*.cryptocurrency' => ['required', new Enum(Cryptocurrency::class)],
        ]);

        if ($insuranceInvoice->isPaid()) {
            $this->respondErrorMessage("Insurance invoice already paid");
        }

        DB::transaction(function () use ($insuranceInvoice, $validated) {
            $insuranceInvoice->insurance->wallets()->delete();
            $insuranceInvoice->insurance->wallets()->createMany($validated['wallets']);
            unset($validated['wallets']);
            $insuranceInvoice->insurance->update($validated);
        });

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
