<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Admin\Components\Messages;
use Modules\Admin\Models\InsuranceCoverageOption;

class InsuranceCoverageOptionController extends BaseAdminController
{
    public function index(): Renderable
    {
        return $this->view('insurance-coverage-option.index', [
            'coverageOptions' => InsuranceCoverageOption::paginate(),
        ]);
    }

    public function create(): Renderable
    {
        return $this->view('insurance-coverage-option.edit', [
            'coverageOption' => new InsuranceCoverageOption(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'coverage' => 'required|numeric|min:1',
            'price_percentage' => 'required|numeric|between:0,100',
        ]);

        $insuranceCoverageOption = InsuranceCoverageOption::create($validated);

        Messages::success('Insurance Coverage Option created successfully.');

        return redirect()->route('admin.insurance-coverage-option.edit', $insuranceCoverageOption->id);
    }

    public function edit(InsuranceCoverageOption $insuranceCoverageOption): Renderable
    {
        return $this->view('insurance-coverage-option.edit', [
            'coverageOption' => $insuranceCoverageOption,
        ]);
    }

    public function update(Request $request, InsuranceCoverageOption $insuranceCoverageOption): RedirectResponse
    {
        $validated = $request->validate([
            'coverage' => 'numeric|min:1',
            'price_percentage' => 'numeric|between:0,100',
        ]);

        $insuranceCoverageOption->update($validated);
        Messages::success('Insurance Coverage Option updated successfully.');

        return redirect()->route('admin.insurance-coverage-option.edit', $insuranceCoverageOption->id);
    }

    public function destroy(InsuranceCoverageOption $insuranceCoverageOption): RedirectResponse
    {
        $insuranceCoverageOption->delete();
        Messages::success('Insurance Coverage Option deleted successfully.');

        return redirect()->route('admin.insurance-coverage-option.index');
    }
}
