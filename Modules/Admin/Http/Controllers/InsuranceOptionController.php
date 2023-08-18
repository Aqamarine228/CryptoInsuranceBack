<?php

namespace Modules\Admin\Http\Controllers;

use App\Enums\InsuranceOptionFieldType;
use App\Rules\AllLanguagesRule;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Admin\Components\Messages;
use Modules\Admin\Http\Resources\InsuranceOptionResource;
use Modules\Admin\Models\InsuranceOption;

class InsuranceOptionController extends BaseAdminController
{

    const ITEMS_PER_SEARCH = 10;

    public function index(): Renderable
    {
        $insuranceOptions = InsuranceOption::paginate(15);

        return $this->view('insurance-option.index', ['insuranceOptions' => $insuranceOptions]);
    }

    public function create(): Renderable
    {
        $insuranceOption = new InsuranceOption;
        return $this->view('insurance-option.edit', ['insuranceOption' => $insuranceOption]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => new AllLanguagesRule('required', 'string', 'max:255'),
            'description' => new AllLanguagesRule('required', 'string', 'max:250'),
            'price' => 'required|decimal:0,2'
        ]);

        $validated['slug'] = Str::slug($validated["name_" . locale()->default()]);

        $insuranceOption = InsuranceOption::create($validated);

        Messages::success('Insurance option created successfully!');

        return redirect()->route('admin.insurance-option.edit', $insuranceOption->id);
    }

    public function edit(InsuranceOption $insuranceOption): Renderable
    {
        $insuranceOption->load('fields');
        return $this->view('insurance-option.edit', ['insuranceOption' => $insuranceOption]);
    }

    public function update(Request $request, InsuranceOption $insuranceOption): RedirectResponse
    {
        $validated = $request->validate([
            'name' => new AllLanguagesRule('string', 'max:255'),
            'description' => new AllLanguagesRule('string', 'max:250'),
            'price' => 'decimal:0,2'
        ]);

        $insuranceOption->update($validated);

        Messages::success('Insurance option updated successfully!');

        return redirect()->route('admin.insurance-option.edit', $insuranceOption->id);
    }

    public function destroy(InsuranceOption $insuranceOption): RedirectResponse
    {
        $insuranceOption->delete();
        Messages::success('Insurance option deleted successfully!');

        return redirect()->route('admin.insurance-option.index');
    }


    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'string|nullable|max:255',
        ]);

        if (array_key_exists('name', $validated) && $validated['name']) {
            $options = InsuranceOption::search($validated['name'])->take(self::ITEMS_PER_SEARCH)->get();
        } else {
            $options = InsuranceOption::take(self::ITEMS_PER_SEARCH)->get();
        }

        return new JsonResponse(InsuranceOptionResource::collection($options));
    }
}
