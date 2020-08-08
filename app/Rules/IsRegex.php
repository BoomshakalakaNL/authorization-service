<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsRegex implements Rule 
{
    public function passes($attribute, $value)
    {
        return !(@preg_match($value, null) === false);         
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid regular expression, that matches PHP preg_match()';
    }
}