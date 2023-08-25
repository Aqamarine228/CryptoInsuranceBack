<?php

namespace Modules\ClientApi\Http\Controllers;

use App\Enums\PaymentTransactionStatus;
use DB;
use Illuminate\Http\Request;
use Modules\ClientApi\Models\PaymentTransaction;
use Symfony\Component\HttpFoundation\Response;

class PaymentTransactionController extends BaseClientApiController
{

    public function shkeeperAcceptTransaction(Request $request): Response
    {
        $validated = $request->validate([
            'external_id' => 'required|exists:payment_transactions,uuid',
            'paid' => 'required|bool'
        ]);

        if (!$validated['paid']) {
            return new Response(status: Response::HTTP_ACCEPTED);
        }

        $transaction = PaymentTransaction::where('uuid', $validated['external_id'])->first();
        DB::transaction(function () use ($transaction) {
            $transaction->payable->paid();
            $transaction->update([
                'status' => PaymentTransactionStatus::PAID,
            ]);
        });

        return new Response(status: Response::HTTP_ACCEPTED);
    }
}
