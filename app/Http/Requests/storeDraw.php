<?php

namespace App\Http\Requests;

use App\Enums\PrizeTypes;
use App\Rules\NumberMustNotBelongToWinner;
use App\Rules\ReachedPrizeTypeLimit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class storeDraw extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'   => [
                'required',
                Rule::in(PrizeTypes::toArray()),
                new ReachedPrizeTypeLimit,
            ],
            'number' => [
                'required',
                'numeric',
                'exists:numbers,value',
                'unique:draws,number',
                new NumberMustNotBelongToWinner,
            ],
        ];
    }
}
