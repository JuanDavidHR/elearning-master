<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nombre'  => 'string|required|min: 3|max: 80',
            'num_documento' => 'required|unique:entidad,num_documento,'.$this->id. ',id|min :8|max:9',            
        ];
    }
    public function messages(){
        return [
            'nombre.string' => 'Ingrese Nombre',
            'nombre.required' => 'Ingrese Nombre',
            'nombre.min' => 'Ingrese Nombre',
            'nombre.max' => 'Máximo 30 dígitos',
            'num_documento.integer' => 'Ingrese DNI',
            'num_documento.required' => 'Ingrese DNI',
            'num_documento.min' => 'Ingrese DNI válido',
            'num_documento.max' => 'Ingrese DNI válido',
        ];
    }
}
