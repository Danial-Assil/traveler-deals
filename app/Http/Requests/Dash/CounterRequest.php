<?php

namespace App\Http\Requests\Dash;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CounterRequest extends FormRequest
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

        $id = isset($this->counter) ? $this->counter->id : null;
        $rules = [
            'number' => 'integer|min:1',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.title' => ['required']]; //, Rule::unique('counter_translations', 'title')->ignore($id, 'counter_id')]];
        }

        return $rules;
    }
}
