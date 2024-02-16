<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;


class SaudiMobileNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure  $fail
     * @return void
     */
    public function validate($attribute, $value, Closure $fail): void
    {
        if (!preg_match('/^(9665|05)([0-9]{8})$/', $value)) {
            $fail('يجب أن يكون :attribute رقم جوال صالح في المملكة العربية السعودية.');
        }
    }
}
