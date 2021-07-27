<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AboutsRequest extends FormRequest
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
        return [
            'title' => ['required', 'max:150'],
            'text' => ['required'],
            'mission' => ['max:250'],
            'vision' => ['max:250'],
            'values' => ['max:250'],
            'user_id' => ['required']
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => 'Título',
            'text' => 'Descrição',
            'mission' => 'Missão',
            'vision' => 'Visão',
            'values' => 'Valores',
        ];
    }
}
