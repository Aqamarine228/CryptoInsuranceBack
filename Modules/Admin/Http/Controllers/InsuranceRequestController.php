<?php

namespace Modules\Admin\Http\Controllers;

use App\Rules\AllLanguagesRule;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Admin\Components\Messages;
use Modules\Admin\Models\InsuranceRequest;
use Modules\Admin\Notifications\InsuranceRequestNotification;

class InsuranceRequestController extends BaseAdminController
{

    public function index(): Renderable
    {
        return $this->view('insurance-request.index', [
            'insuranceRequests' => InsuranceRequest::pending()->with('option')->paginate()
        ]);
    }

    public function show(InsuranceRequest $insuranceRequest): Renderable
    {
        $insuranceRequest->load('fields');
        $insuranceRequest->load('option.fields');
        return $this->view('insurance-request.show', [
            'insuranceRequest' => $insuranceRequest
        ]);
    }

    public function approve(InsuranceRequest $insuranceRequest): RedirectResponse
    {
        $insuranceRequest->approve();
        $insuranceRequest->user->notify(new InsuranceRequestNotification($insuranceRequest));
        Messages::success("Insurance request approved successfully!");
        return redirect()->route('admin.insurance-request.index');
    }

    public function reject(InsuranceRequest $insuranceRequest): Renderable
    {
        return $this->view('insurance-request.reject', [
            'insuranceRequest' => $insuranceRequest,
        ]);
    }

    public function rejectSubmit(Request $request, InsuranceRequest $insuranceRequest): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => new AllLanguagesRule('required', 'string', 'max:255')
        ]);
        $insuranceRequest->reject($validated);
        $insuranceRequest->user->notify(new InsuranceRequestNotification($insuranceRequest->fresh()));
        Messages::success("Insurance request rejected successfully!");
        return redirect()->route('admin.insurance-request.index');
    }
}
