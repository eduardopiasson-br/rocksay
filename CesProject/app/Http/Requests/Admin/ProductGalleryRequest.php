<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductGalleryRequest extends FormRequest
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
            'name' => ['required', 'max:150'],
            'image' => ['required'],
            'status' => [''],
            'position' => [''],
            'user_id' => ['required'],
            'product_id' => ['required']
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
            'name' => 'Nome para Imagem',
            'image' => 'Imagem da Galeria'
        ];
    }
}
