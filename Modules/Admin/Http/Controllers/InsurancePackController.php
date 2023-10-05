<?php

namespace Modules\Admin\Http\Controllers;

use App\Actions\GenerateSlug;
use App\Rules\AllLanguagesRule;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Components\Messages;
use Modules\Admin\Models\InsurancePack;

class InsurancePackController extends BaseAdminController
{
    public function index(): Renderable
    {
        $insurancePacks = InsurancePack::paginate(15);
        return $this->view('insurance-pack.index', [
            'insurancePacks' => $insurancePacks
        ]);
    }

    public function create(): Renderable
    {
        return $this->view('insurance-pack.edit', [
            'insurancePack' => new InsurancePack()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => new AllLanguagesRule('required', 'string', 'max:255'),
            'description' => new AllLanguagesRule('required', 'string', 'max:250'),
            'price' => 'required|numeric|min:1',
            'insurance_options' => 'required|array',
            'insurance_options.*' => 'required|exists:insurance_options,id',
            'coverage' => 'required|numeric|min:1',
        ]);

        $names = [];
        $descriptions = [];
        foreach (locale()->supported() as $locale) {
            $names["name_$locale"] = $validated["name_$locale"];
            $descriptions["description_$locale"] = $validated["description_$locale"];
        }

        $insurancePack = DB::transaction(static function () use ($validated, $names, $descriptions) {
            $insurancePack = InsurancePack::create([
                'price' => $validated['price'],
                'slug' => GenerateSlug::execute($validated['name_'.locale()->default()]),
                'coverage' => $validated['coverage'],
                ...$names,
                ...$descriptions
            ]);

            $insurancePack->insuranceOptions()->sync($validated['insurance_options']);

            Messages::success("Insurance pack created successfully.");

            return $insurancePack;
        });

        return redirect()->route('admin.insurance-pack.edit', $insurancePack->id);
    }

    public function edit(InsurancePack $insurancePack): Renderable
    {
        $insurancePack->load('insuranceOptions');
        return $this->view('insurance-pack.edit', [
            'insurancePack' => $insurancePack,
        ]);
    }

    public function update(Request $request, InsurancePack $insurancePack): RedirectResponse
    {
        $validated = $request->validate([
            'name' => new AllLanguagesRule('required', 'string', 'max:255'),
            'description' => new AllLanguagesRule('required', 'string', 'max:250'),
            'price' => 'numeric|min:1',
            'coverage' => 'numeric|min:1'
        ]);

        $validatedInsuranceOptions = $request->validate([
            'insurance_options' => 'required|array',
            'insurance_options.*' => 'required|exists:insurance_options,id',
        ]);

        DB::transaction(static function () use ($validated, $validatedInsuranceOptions, $insurancePack) {
            $insurancePack->update($validated);
            $insurancePack->insuranceOptions()->sync(array_values($validatedInsuranceOptions['insurance_options']));
        });

        Messages::success('Insurance pack updated successfully.');

        return redirect()->route('admin.insurance-pack.edit', $insurancePack->id);
    }

    public function destroy(InsurancePack $insurancePack): RedirectResponse
    {
        $insurancePack->delete();

        Messages::success('Insurance pack deleted successfully.');

        return redirect()->route('admin.insurance-pack.index');
    }
}
