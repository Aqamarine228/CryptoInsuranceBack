<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Validation\Validator;

class AllLanguagesRule implements ValidationRule, ValidatorAwareRule
{

    private array $rules;
    protected Validator $validator;
    public bool $implicit = true;

    public function __construct(...$rules)
    {
        $this->rules = $rules;
    }

    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $replace = false;
        if (str_contains($attribute, '{locale}')) {
            $replace = true;
        }
        $localeRules = [];
        foreach (locale()->supported() as $locale) {
            $localeRules[$replace
                ? str_replace('{locale}', $locale, $attribute)
                : "{$attribute}_$locale"] = $this->rules;
        }

        $previousRules = $this->validator->getRules();
        unset($previousRules[$attribute]);
        $this->validator->setRules(array_merge($previousRules, $localeRules));
        $this->validator->validate();
    }
}
