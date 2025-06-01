<?php

namespace App\Http\Requests\Dash;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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


        $id = isset($this->project) ? $this->project->id : null;

        $rules = [
            // 'image' => 'required|image|mimes:jpg,jpeg,png',
            // 'default_lang' => 'required'
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.site_name' => 'required'];
            $rules += [$locale . '.keywords' => 'required'];
            $rules += [$locale . '.description' => 'required'];
            $rules += [$locale . '.footer_desc' => 'required'];
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'ar.site_name' => 'اسم الموقع',
        ];
    }
}
