<?php

namespace App\Http\Requests\Dash;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CategoryRequest extends FormRequest
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

        $rules = [
            'image' => 'image|mimes:jpg,jpeg,png',
        ];

      
        foreach (config('translatable.locales') as $locale) {
            // $rules += [$locale . '.title' => ['required', Rule::unique('category_translations', 'title')->ignore($id, 'category_id')]];
            $rules += [$locale . '.title' => ['required']];
        }

        return $rules;
    }
}
