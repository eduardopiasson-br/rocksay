<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

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
        $rules = [
            'title' => ['required', 'max:150'],
            'text' => ['required'],
            'image' => [''],
            'video' => [''],
            'start_post' => ['required'],
            'end_post' => [''],
            'autor' => ['max:150'],
            'font' => ['max:150'],
            'font_link' => [''],
            'button' => ['max:100'],
            'button_text' => [''],
            'button_link' => [''],
            'highlight' => [''],
            'status' => [''],
            'user_id' => ['required'],
        ];
                
        if($this->method() == "PUT"){
            $rules['image'] = ['nullable'];
        }

        return $rules;
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
            'text' => 'Texto da Publicação',
            'start_post' => 'Data Inicial',
            'end_date' => 'Data Final',
            'autor' => 'Autor',
            'font' => 'Fonte da Matéria',
            'button' => 'Nome para Botão'
        ];
    }
}
