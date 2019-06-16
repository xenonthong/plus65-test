<?php

namespace App\Rules;

use App\Enums\PrizeTypes;
use App\Models\Draw;
use Illuminate\Contracts\Validation\Rule;

class ReachedPrizeTypeLimit implements Rule
{
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Limit for this prize type has been reached.';
    }

    /**
     * Implement draws limit based on prize type.
     *  - First Prize = 1
     *  - Second prize = 2
     *  - Third prize = 3
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        switch ($value) {
            case (string)PrizeTypes::SECOND():
                $max = 2;
                break;
            case (string)PrizeTypes::THIRD():
                $max = 3;
                break;
            default:
                $max = 1;
        }

        return Draw::where('type', $value)->count() < $max;
    }
}
