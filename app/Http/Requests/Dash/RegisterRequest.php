<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => 'required|string|min:4|max:50',
            'password' => 'required|string|min:6|max:50',
            'confirm_password' => 'required|string|same:password',
            // 'agree' => 'required',
        ];
 
        return $rules;
    }
}
