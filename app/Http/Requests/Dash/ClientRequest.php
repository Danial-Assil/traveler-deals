<?php

namespace App\Http\Requests\Dash;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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

        $id = isset($this->client) ? $this->client->id : null;
        $rules = [
            'image' => 'image|mimes:jpg,jpeg,png',
        ];
 

        return $rules;
    }
}
