<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MustStartWithCompanyName implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $company = current_company();

        if ($company !== null && ! str(strtolower($value))->startsWith(strtolower($company->name))) {
            $fail('Vous devez commencer par le mot: '.str($company->name)->title());
        }
    }
}
