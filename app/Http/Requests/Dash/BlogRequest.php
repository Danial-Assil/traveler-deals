<?php

namespace App\Http\Requests\Dash;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
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
        $id = isset($this->slider) ? $this->slider->id : null;
        $rules = [
            // 'image' => 'image|mimes:jpg,jpeg,png',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.title' => ['required', Rule::unique('blog_translations', 'title')->ignore($id, 'blog_id')]];
        }

        return $rules;
    }
}
