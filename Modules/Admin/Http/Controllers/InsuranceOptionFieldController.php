<?php

namespace Modules\Admin\Http\Controllers;

use App\Enums\InsuranceOptionFieldType;
use App\Models\InsuranceOptionField;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Admin\Components\Messages;
use Modules\Admin\Models\InsuranceOption;

class InsuranceOptionFieldController extends BaseAdminController
{
    public function add(Request $request, InsuranceOption $insuranceOption): RedirectResponse
    {
        $validated = $request->validate([
            'names_ru' => 'required|array',
            'names_ru.*' => 'required|string|max:255',
            'names_en' => 'required|array',
            'names_en.*' => 'required|string|max:255',
            'types' => 'required|array',
            'types.*' => 'required|string|in:' . InsuranceOptionFieldType::stringValues(),
        ]);

        $fields = [];
        for ($i = 0; $i < count($validated['types']); $i++) {
            $fields[] = [
                'name_ru' => $validated['names_ru'][$i],
                'name_en' => $validated['names_en'][$i],
                'type' => $validated['types'][$i],
                'insurance_option_id' => $insuranceOption->id,
            ];
        }

        $insuranceOption->fields()->createMany($fields);
        Messages::success('Insurance option fields added successfully!');

        return redirect()->back();
    }

    public function update(Request $request, InsuranceOptionField $insuranceOptionField): RedirectResponse
    {
        $validated = $request->validate([
            'name_ru' => 'string|max:255',
            'name_en' => 'string|max:255',
        ]);

        $insuranceOptionField->update($validated);
        Messages::success('Insurance option field updated successfully!');
        return redirect()->back();
    }

    public function delete(InsuranceOptionField $insuranceOptionField): RedirectResponse
    {
        $insuranceOptionField->delete();
        Messages::success('Insurance option field deleted successfully!');
        return redirect()->back();
    }
}
