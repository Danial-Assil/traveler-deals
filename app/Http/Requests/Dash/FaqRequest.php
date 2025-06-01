<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class FaqRequest extends FormRequest
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
        ];

     
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.question' => ['required']];
            $rules += [$locale . '.answer' => ['required']];
        }

        return $rules;
    }
}
