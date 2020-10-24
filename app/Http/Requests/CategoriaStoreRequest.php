<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   public function rules()
    {
        return [
            'nombre' => 'required|unique:categoria',
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la Categoría es Necesario',
            'nombre.unique'  => 'El nombre de la Categoría ya se encuentra en uso',
        ];
    }
}
