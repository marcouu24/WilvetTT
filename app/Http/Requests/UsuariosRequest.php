<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'unique:users,email'
        ];


        
    }


    public function messages()
    {
        return [
            'user.email.unique' => 'El RUT puede tener un máximo de 10 caracteres',
           
        
        ];
    }
}
