<?php

namespace App\Http\Requests\Dash;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
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

        $id = isset($this->menu) ? $this->menu->id : null;

        $rules = [
            'title' => 'required'
        ];
 

        return $rules;
    }
}
