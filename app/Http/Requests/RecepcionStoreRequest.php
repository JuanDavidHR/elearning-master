<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecepcionStoreRequest extends FormRequest
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
            'nombre' => 'string|required|unique:recepcion,nombre|min:3|max:30',
        ];
    }
    public function messages()
    {
        return [
            'nombre.string' => 'Ingrese Guía',
            'nombre.required' => 'Ingrese Guía',
            'nombre.unique' => 'Guía en uso',
            'nombre.min' => 'Mínimo son 3 dígitos por Guía',
            'nombre.max' => 'Máximo son 30 dígitos por Guía',
        ];
    }
}
