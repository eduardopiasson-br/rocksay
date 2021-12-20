<?php

namespace App\Http\Requests\Admin;


use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
        $id = $this->id;

        $rules = [
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'password' => ['required', 'confirmed', 'min:6']
        ];

        if($this->method() == "PUT"){
            $rules['password'] = ['nullable', 'min:6'];
            $rules['password_confirmation'] = ['nullable','same:password','min:6'];
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
            'name' => 'Nome do Usuário',
            'email' => 'Email do Usuário',
            'password' => 'Senha',
            'password_confirmation' => 'Confirmação de Senha'
        ];
    }
}
