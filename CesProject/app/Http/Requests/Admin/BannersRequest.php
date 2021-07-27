<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BannersRequest extends FormRequest
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
            'name' => ['required', 'max:150'],
            'image_desktop' => [''],
            'image_mobile' => [''],
            'whatsapp' => ['max:14'],
            'facebook' => [''],
            'instagram' => [''],
            'site' => [''],
            'start_date' => ['required'],
            'end_date' => [''],
            'status' => [''],
            'position' => ['required'],
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
            'name' => 'Nome',
            'whatsapp' => 'WhatsApp',
            'start_date' => 'Data Inicial',
            'end_date' => 'Data Final',
        ];
    }
}
