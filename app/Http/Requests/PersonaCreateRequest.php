<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaCreateRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'nombre' => 'required|min:3|max:40',
            'num_documento' => 'required|min:0|max:8|unique:entidad,num_documento',
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es necesario.',
            'nombre.min' => 'Ingrese el nombre completo.',
            'nombre.max' => 'No puede ingresar mas de 40 dígitos.',
            'num_documento.required' => 'El Numero de DNI es necesario.',
            'num_documento.min' => 'Ingrese el DNI completo.',
            'num_documento.max' => 'No puede ingresar mas de 8 dígitos.',
        ];
    }
    
}
