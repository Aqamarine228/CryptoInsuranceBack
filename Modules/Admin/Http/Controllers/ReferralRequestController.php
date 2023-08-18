<?php

namespace Modules\Admin\Http\Controllers;

use App\Enums\ReferralRequestStatus;
use App\Rules\AllLanguagesRule;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Components\Messages;
use Modules\Admin\Models\ReferralRequest;
use Modules\Admin\Notifications\ReferralRequestNotification;

class ReferralRequestController extends BaseAdminController
{

    public function index(): Renderable
    {
        $referralRequests = ReferralRequest::where('status', ReferralRequestStatus::PENDING)->paginate();

        return $this->view('referral-request.index', [
            'referralRequests' => $referralRequests
        ]);
    }

    public function show(ReferralRequest $referralRequest): Renderable
    {
        $referralRequest->load('user');
        $lastReferralRequest = $referralRequest
            ->user
            ->referralRequests()
            ->where('status', ReferralRequestStatus::REJECTED)
            ->latest()
            ->first();
        $lastRejectionReason = $lastReferralRequest?->toArray()['rejection_reason_'.locale()->default()];
        return $this->view('referral-request.show', [
            'referralRequest' => $referralRequest,
            'lastRejectionReason' => $lastRejectionReason,
        ]);
    }

    public function approve(ReferralRequest $referralRequest): RedirectResponse
    {
        DB::transaction(static function () use ($referralRequest) {
            $referralRequest->user->createReferralId();
            $referralRequest->approve();
            $referralRequest->user->notify(new ReferralRequestNotification($referralRequest->fresh()));
        });

        Messages::success('Referral request approved successfully');

        return redirect()->route('admin.referral-request.index');
    }

    public function reject(ReferralRequest $referralRequest): Renderable
    {
        return $this->view('referral-request.reject', [
            'referralRequest' => $referralRequest,
        ]);
    }

    public function submitReject(Request $request, ReferralRequest $referralRequest): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => new AllLanguagesRule('required', 'string', 'max:255'),
        ]);

        DB::transaction(static function () use ($referralRequest, $validated) {
            $referralRequest->reject($validated);
            $referralRequest->user->notify(new ReferralRequestNotification($referralRequest->fresh()));
        });

        Messages::success('Referral request rejected successfully');

        return redirect()->route('admin.referral-request.index');
    }
}
