<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FielStoreRequest extends FormRequest
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
            'documento_remision' => 'string|required|unique:fiel,documento_remision|min:5|max:90',
            'fecha_remision'=> 'required',
            'fecha_recepcion'=> 'required',
            'contrato' => 'string|required|unique:fiel,contrato|min:5|max:90',
            'monto_contrato' => 'required|numeric|min:1|max:99999999',
            'monto_garantia' => 'required|numeric|min:1|max:99999999',
            'fecha_inicio_garantia'=> 'required',
            'fecha_termino_garantia'=> 'required',
            'fecha_inicio_contrato'=> 'required',
            'fecha_termino_contrato'=> 'required'
        ];
    }
    public function messages(){
        return [
            'documento_remision.unique' => 'El documento ya se encuentra registrado.',
            'documento_remision.string' => 'Ingrese el documento.',
            'documento_remision.required' => 'Ingrese el documento.',
            'documento_remision.min' => 'Se permiten de 5 a 90 caracteres.',
            'documento_remision.max' => 'Se permiten de 5 a 90 caracteres.',
            'contrato.unique' => 'El documento ya se encuentra registrado.',
            'contrato.string' => 'Ingrese el documento.',
            'contrato.required' => 'Ingrese el documento.',
            'contrato.min' => 'Se permiten de 5 a 90 caracteres.',
            'contrato.max' => 'Se permiten de 5 a 90 caracteres.',
            'fecha_remision.required' => 'Ingrese Fecha.',
            'fecha_recepcion.required' => 'Ingrese Fecha.',
            'monto_contrato.required' => 'Ingrese monto.',
            'monto_contrato.numeric' => 'Ingrese monto correcto.',
            'monto_contrato.min' => 'Rangos desde 1 hasta 99,999,999.',
            'monto_contrato.max' => 'Rangos desde 1 hasta 99,999,999.',
            'monto_garantia.required' => 'Ingrese monto.',
            'monto_garantia.numeric' => 'Ingrese monto correcto.',
            'monto_garantia.min' => 'Rangos desde 1 hasta 99,999,999.',
            'monto_garantia.max' => 'Rangos desde 1 hasta 99,999,999.',
            'fecha_inicio_garantia.required' => 'Ingrese Fecha.',
            'fecha_termino_garantia.required' => 'Ingrese Fecha.',
            'fecha_inicio_contrato.required' => 'Ingrese Fecha.',
            'fecha_termino_contrato.required' => 'Ingrese Fecha.',
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
