<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class OrderRequest extends ApiRequest
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

            'before_date' => 'required|date|date_format:Y-m-d|after:today',
            'name' => 'required|string',
            
            'reward' => 'required|numeric',
            'deal_method' => 'required',
            //'delivery_type' => 'required',
            'notes' => 'nullable', 
            'products' => 'required|array',
            'products.*.link' => 'url',
            'products.*.name' => 'required|string',
            'products.*.quantity' => 'required|string',
            'products.*.price' => 'required|string',
            'products.*.weight' => 'required|string',
            'products.*.category_id' => 'required|string|exists:categories,id',
            'products.*.photo' => 'required|image|mimes:jpg,jpeg,png',
        ];
 
        return $rules;
    }
 

    
}
