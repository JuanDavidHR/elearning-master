<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParametroUpdateRequest extends FormRequest
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
            'nombreParametro' => 'required|unique:parametro,nombreParametro,' .$this->idParametro. ',idParametro|min:3|max:20',
            'inicialParametro' => 'required|unique:parametro,inicialParametro,' .$this->idParametro. ',idParametro|min:1|max:3',
        ];
    }
    public function messages(){
        return [
            'nombreParametro.required' => 'Ingrese Dato',
            'nombreParametro.unique' => 'Dato Duplicado',
            'nombreParametro.min' => 'Mínimo 3',
            'nombreParametro.max' => 'Máximo 20',
            'inicialParametro.required' => 'Ingrese Dato',
            'inicialParametro.unique' => 'Dato Duplicado',
            'inicialParametro.min' => 'Mínimo 1',
            'inicialParametro.max' => 'Máximo 3',

        ];
    }
}
