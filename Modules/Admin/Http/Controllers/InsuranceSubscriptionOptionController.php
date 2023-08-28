<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Admin\Components\Messages;
use Modules\Admin\Models\InsuranceSubscriptionOption;

class InsuranceSubscriptionOptionController extends BaseAdminController
{
    private const SECONDS_PER_DAY = 60 * 60 * 24;
    public function index(): Renderable
    {
        return $this->view('insurance-subscription-option.index', [
            'subscriptionOptions' => InsuranceSubscriptionOption::paginate(),
        ]);
    }

    public function create(): Renderable
    {
        return $this->view('insurance-subscription-option.edit', [
            'subscriptionOption' => new InsuranceSubscriptionOption(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sale_percentage' => 'required|numeric|between:0,100',
            'days' => 'required|numeric|after_or_equal:1',
        ]);

        $validated['duration'] = $validated['days'] * self::SECONDS_PER_DAY;
        unset($validated['days']);

        $insuranceSubscriptionOption = InsuranceSubscriptionOption::create($validated);

        Messages::success('Insurance Subscription Option created successfully.');

        return redirect()->route('admin.insurance-subscription-option.edit', $insuranceSubscriptionOption->id);
    }

    public function edit(InsuranceSubscriptionOption $insuranceSubscriptionOption): Renderable
    {
        return $this->view('insurance-subscription-option.edit', [
            'subscriptionOption' => $insuranceSubscriptionOption,
        ]);
    }

    public function update(Request $request, InsuranceSubscriptionOption $insuranceSubscriptionOption): RedirectResponse
    {
        $validated = $request->validate([
            'sale_percentage' => 'numeric|between:0,100',
            'days' => 'numeric|after_or_equal:1',
        ]);

        if (array_key_exists('days', $validated)) {
            $validated['duration'] = $validated['days'] * self::SECONDS_PER_DAY;
            unset($validated['days']);
        }

        $insuranceSubscriptionOption->update($validated);
        Messages::success('Insurance Subscription Option updated successfully.');

        return redirect()->route('admin.insurance-subscription-option.edit', $insuranceSubscriptionOption->id);
    }

    public function destroy(InsuranceSubscriptionOption $insuranceSubscriptionOption): RedirectResponse
    {
        $insuranceSubscriptionOption->delete();
        Messages::success('Insurance Subscription Option deleted successfully.');

        return redirect()->route('admin.insurance-subscription-option.index');
    }
}
