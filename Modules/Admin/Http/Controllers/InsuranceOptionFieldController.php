<?php

namespace Modules\Admin\Http\Controllers;

use App\Enums\InsuranceOptionFieldType;
use App\Rules\AllLanguagesRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Modules\Admin\Components\Messages;
use Modules\Admin\Models\InsuranceOption;
use Modules\Admin\Models\InsuranceOptionField;

class InsuranceOptionFieldController extends BaseAdminController
{
    public function add(Request $request, InsuranceOption $insuranceOption): RedirectResponse
    {
        $localeNames = [];
        foreach (locale()->supported() as $locale) {
            $localeNames["names_$locale.*"] = ['required', 'string', 'max:255'];
        }

        $validated = $request->validate([
            'names' => new AllLanguagesRule('required', 'array'),
            'types' => 'required|array',
            'types.*' => ['required', 'string', new Enum(InsuranceOptionFieldType::class)],
            'required' => 'required|array',
            'required.*' => 'required|boolean',
            ...$localeNames,
        ]);

        $fields = [];
        for ($i = 0; $i < count($validated['types']); $i++) {
            $nameFields = [];
            foreach (locale()->supported() as $locale) {
                $nameFields["name_$locale"] = $validated["names_$locale"][$i];
            }
            $fields[] = [
                'type' => $validated['types'][$i],
                'required' => $validated['required'][$i],
                'slug' => Str::slug($validated['names_' . locale()->default()][$i]),
                'insurance_option_id' => $insuranceOption->id,
                ...$nameFields
            ];
        }

        $insuranceOption->fields()->createMany($fields);
        Messages::success('Insurance option fields added successfully!');

        return redirect()->back();
    }

    public function update(Request $request, InsuranceOptionField $insuranceOptionField): RedirectResponse
    {
        $validated = $request->validate([
            'name' => new AllLanguagesRule('string', 'max:255'),
            'required' => 'string|in:on',
        ]);

        $validated['required'] = array_key_exists('required', $validated);

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
