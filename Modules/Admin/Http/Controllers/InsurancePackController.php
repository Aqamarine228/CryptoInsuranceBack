<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Admin\Components\Messages;
use Modules\Admin\Http\Resources\InsuranceOptionResource;
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
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'description_en' => 'required|string|max:255',
            'description_ru' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'insurance_options' => 'required|array',
            'insurance_options.*' => 'required|exists:insurance_options,id',
        ]);

        $insurancePack = DB::transaction(static function () use ($validated) {
            $insurancePack = InsurancePack::create([
                'name_en' => $validated['name_en'],
                'name_ru' => $validated['name_ru'],
                'description_en' => $validated['description_en'],
                'description_ru' => $validated['description_ru'],
                'price' => $validated['price'],
                'slug' => Str::slug($validated['name_en']),
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
            'name_en' => 'string|max:255',
            'name_ru' => 'string|max:255',
            'description_en' => 'string|max:255',
            'description_ru' => 'string|max:255',
            'price' => 'numeric|min:1',
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
