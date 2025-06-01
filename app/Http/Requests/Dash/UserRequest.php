<?php

namespace App\Http\Requests\Dash;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = isset($this->id) ? $this->id : null;

        $rules = [
            'image' => 'image|mimes:jpg,jpeg,png',
            // 'username' => 'required|string|min:4|max:50|unique:users',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|max:10',
            'mobile' => 'required',
        ];
 
 
        return $rules;
    }
}
