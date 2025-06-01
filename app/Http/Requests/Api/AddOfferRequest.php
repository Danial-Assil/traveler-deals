<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class AddOfferRequest extends ApiRequest
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

        $rules = [
            'trip_id' => 'required|exists:trips,id',
            'order_id' => 'required|exists:orders,id',
            'reward' => 'required|numeric',
            'amount' => 'required|numeric',
        ];

        return $rules;
    }
}
