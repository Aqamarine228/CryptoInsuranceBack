<?php

namespace Modules\ClientApi\Http\Controllers;

use App\Enums\InsuranceOptionFieldType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\ClientApi\Models\InsuranceOption;
use Modules\ClientApi\Models\User;

class InsuranceRequestController extends BaseClientApiController
{
    public function __invoke(Request $request, InsuranceOption $insuranceOption): JsonResponse
    {
        if (!$this->userIsAbleToSubmitRequest($request->user())) {
            return $this->respondErrorMessage(__('errors.referralRequestAlreadyExists'));
        }

        $validated = $request->validate($this->createValidationRules($insuranceOption));
        $insuranceOption->load('fields');
        $fields = $this
            ->fieldsFromValidated($validated, $insuranceOption->fields->pluck('id', 'slug'));
        DB::transaction(function () use ($fields, $insuranceOption, $request) {
            $insuranceRequest = $request->user()->insuranceRequests()->create([
                'insurance_option_id' => $insuranceOption->id,
                'coverage' => $request->user()->insurances()->active()->first()->coverage
            ]);

            $insuranceRequest->fields()->createMany($fields);
        });
        return $this->respondSuccess('Insurance request created successfully');
    }

    private function userIsAbleToSubmitRequest(User $user): bool
    {
        return !$user->insuranceRequests()->pending()->exists();
    }

    private function createValidationRules(InsuranceOption $insuranceOption): array
    {
        $rules = [];
        foreach ($insuranceOption->fields as $field) {
            $rules[$field->slug] = [];
            $field->required && $rules[$field->slug][] = 'required';
            $field->type === InsuranceOptionFieldType::TEXT && $rules[$field->slug][] = 'string';
            $field->type === InsuranceOptionFieldType::TEXT && $rules[$field->slug][] = 'max:255';
            $field->type === InsuranceOptionFieldType::NUMBER && $rules[$field->slug][] = 'numeric';
        }

        return $rules;
    }

    private function fieldsFromValidated(array $validated, Collection $fields): array
    {
        $forms = [];
        foreach ($fields as $key => $value) {
            $forms[] = [
                'value' => $validated[$key] ?? null,
                'insurance_option_field_id' => $value,
            ];
        }
        return $forms;
    }
}
