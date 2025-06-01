<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class LoginRequest extends ApiRequest
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
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ];
 
        return $rules;
    }
 
}
