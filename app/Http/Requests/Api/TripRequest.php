<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class TripRequest extends ApiRequest
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
            
            'from' => 'required',
            'to' => 'required', 

            'available_weight' => 'required|numeric',
            'departure_date' => 'required|date|date_format:Y-m-d|after:today',
            'departure_time' => 'required',
            'delivery_date_from' => 'required|date|date_format:Y-m-d|after:today',
            'delivery_date_to' => 'required|date|date_format:Y-m-d|after:today',
            'pickup_place' => 'required',
            'booking_airline' => 'required',
            'booking_reference' => 'required',
            'booking_first_name' => 'required',
            'booking_last_name' => 'required',
            'deal_method' => 'required|numeric',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'passport_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            // 'categories_not_accept' => 'array', 
            'notes' => 'nullable|string'
        ];
 
        return $rules;
    }
 
}
