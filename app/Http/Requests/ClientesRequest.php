<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientesRequest extends FormRequest
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
            'cliente.nombre' => 'required|max:30',
            'cliente.comuna' => 'required|max:30',
            'cliente.direccion' => 'required|max:70',
            'cliente.rut' => 'required|max:10',
            'cliente.telefono' => 'required|max:20',
            'cliente.email' => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
            'cliente.rut.max' => 'El RUT puede tener un máximo de 10 caracteres',
            'cliente.rut.required' => 'El RUT no puede estar vacío.',
            'cliente.nombre.max' => 'El Nombre puede tener un máximo de 30 caracteres',
            'cliente.nombre.required' => 'El Nombre no puede estar vacío.',
            'cliente.comuna.max' => 'La Comuna puede tener un máximo de 30 caracteres',
            'cliente.comuna.required' => 'La Comuna no puede estar vacía.',
            'cliente.direccion.max' => 'La Dirección puede tener un máximo de 70 caracteres',
            'cliente.direccion.required' => 'La Dirección no puede estar vacía.',       
         
            'cliente.telefono.max' => 'El Teléfono puede tener un máximo de 9 caracteres',
            'cliente.telefono.required' => 'El Teléfono no puede estar vacío.',
            'cliente.email.max' => 'El Correo puede tener un máximo de 50 caracteres',
            'cliente.email.required' => 'El Correo no puede estar vacío.',

        
        ];
    }
}
