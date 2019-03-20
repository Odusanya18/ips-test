<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Http\Helpers\InfusionsoftHelper;

class ValidInfusionsoftMail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!(new InfusionsoftHelper())->getContact($value)) {
            return false;
        }
        
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Infusionsoft Email';
    }
}
