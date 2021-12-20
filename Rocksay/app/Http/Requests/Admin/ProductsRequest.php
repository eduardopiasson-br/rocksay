<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
            'title' => ['required', 'max:100'],
            'price' => ['required', 'max:45'],
            'price_promo' => ['max:45'],
            'prazo' => ['max:50'],
            'abstract' => ['max:250'],
            'sizes' => [''],
            'image' => [''],
            'units' => [''],
            'out_stock' => [''],
            'photo_name' => ['max:150'],
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
            'title' => 'Título do Produto',
            'price' => 'Preço do Produto',
            'price_promo' => 'Preço Promocional',
            'prazo' => 'Preço a Prazo',
            'abstract' => 'Resumo do Produto',
            'sizes' => 'Tamanhos',
            'photo_name' => 'Autor da Foto Principal'
        ];
    }
}
