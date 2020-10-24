<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FielGarantiaRequest extends FormRequest
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
            'monto_adicional_1' => 'required|numeric|min:0|max:99999999',
            'monto_adicional_2' => 'required|numeric|min:0|max:99999999',
            'monto_adicional_3' => 'required|numeric|min:|max:99999999',
            'monto_reduccion' => 'required|numeric|min:0|max:99999999',
            'fecha_termino_ampliacion'=> 'required'
        ];
    }
    public function messages(){
        return [
            'monto_adicional_1.required' => 'Ingrese monto.',
            'monto_adicional_1.numeric' => 'Ingrese monto correcto.',
            'monto_adicional_1.min' => 'Rangos desde 0 hasta 99,999,999.',
            'monto_adicional_1.max' => 'Rangos desde 0 hasta 99,999,999.',
            'monto_adicional_2.required' => 'Ingrese monto.',
            'monto_adicional_2.numeric' => 'Ingrese monto correcto.',
            'monto_adicional_2.min' => 'Rangos desde 0 hasta 99,999,999.',
            'monto_adicional_2.max' => 'Rangos desde 0 hasta 99,999,999.',
            'monto_adicional_3.required' => 'Ingrese monto.',
            'monto_adicional_3.numeric' => 'Ingrese monto correcto.',
            'monto_adicional_3.min' => 'Rangos desde 0 hasta 99,999,999.',
            'monto_adicional_3.max' => 'Rangos desde 0 hasta 99,999,999.',
            'monto_reduccion.required' => 'Ingrese monto.',
            'monto_reduccion.numeric' => 'Ingrese monto correcto.',
            'monto_reduccion.min' => 'Rangos desde 0 hasta 99,999,999.',
            'monto_reduccion.max' => 'Rangos desde 0 hasta 99,999,999.',
            'fecha_termino_ampliacion.required' => 'Ingrese Fecha.',
        ];
    }
}
