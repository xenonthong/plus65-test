<?php

namespace App\Rules;

use App\Models\Draw;
use App\Models\Number;
use Illuminate\Contracts\Validation\Rule;

class NumberMustNotBelongToWinner implements Rule
{
    /**
     * Ensures another number that belongs to an existing winner does
     * not gets saved again.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $number = Number::where('value', $value)->first();

        return Draw::where('user_id', $number->user_id)->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This :attribute belongs to an existing winner.';
    }
}
