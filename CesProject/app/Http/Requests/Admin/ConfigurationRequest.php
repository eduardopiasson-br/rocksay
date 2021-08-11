<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationRequest extends FormRequest
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
            'owner' => ['min:3', 'max:150'],
            'cnpj' => ['required', 'max:100'],
            'address' => ['required', 'max:250'],
            'link_address' => [],
            'footer_text' => ['required'],
            'phone' => ['max:15'],
            'whatsapp' => ['max:15'],
            'telegram' => ['max:15'],
            'instagram' => [],
            'facebook' => [],
            'email' => ['required', 'email', 'max:100'],
            'email_two' => ['max:100'],
            'wellcome_message' => [],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg'],
            'user_id' => ['required'],
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
            'owner' => 'Nome da Proprietária',
            'cnpj' => 'CNPJ',
            'address' => 'Endereço',
            'footer_text' => 'Texto de Rodapé',
            'phone' => 'Telefone',
            'whatsapp' => 'WhatsApp',
            'telegram' => 'Telegram',
            'email' => 'Email',
            'email_two' => 'Email Secundário',
            'image' => 'Imagem Padrão',
        ];
    }
}
