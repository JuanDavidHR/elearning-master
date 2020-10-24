<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DirectoUpdate1Request extends FormRequest
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
            'documento_remision' => 'string|required|unique:directo,documento_remision,'.$this->idDirecto.',idDirecto|min:5|max:90',
            'fecha_remision'=> 'required',
            'fecha_recepcion'=> 'required',
            'contrato' => 'string|required|unique:directo,contrato,'.$this->idDirecto.',idDirecto|min:5|max:90',
            'monto_contrato' => 'required|numeric|min:1|max:99999999',
            'obra' => 'string|required|unique:directo,obra,'.$this->idDirecto.',idDirecto|min:5|max:90',
            'fecha_inicio_plazo'=> 'required',
            'fecha_termino_plazo'=> 'required',
            'monto_adelanto_1' => 'required|numeric|min:1|max:99999999',
            'fecha_desde_adelanto_1'=> 'required',
            'fecha_hasta_adelanto_1'=> 'required',
            'monto_adelanto_2' => 'required|numeric|min:1|max:99999999',
            'fecha_desde_adelanto_2'=> 'required',
            'fecha_hasta_adelanto_2'=> 'required'
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
            'obra.unique' => 'El nombre ya se encuentra registrado.',
            'obra.string' => 'Ingrese el nombre de la obra.',
            'obra.required' => 'Ingrese el nombre de la obra.',
            'obra.min' => 'Se permiten de 5 a 90 caracteres.',
            'obra.max' => 'Se permiten de 5 a 90 caracteres.',
            'fecha_inicio_plazo.required' => 'Ingrese Fecha.',
            'fecha_termino_plazo.required' => 'Ingrese Fecha.',
            'fecha_desde_adelanto_1.required' => 'Ingrese Fecha.',
            'fecha_hasta_adelanto_1.required' => 'Ingrese Fecha.',
            'monto_adelanto_1.required' => 'Ingrese monto.',
            'monto_adelanto_1.numeric' => 'Ingrese monto correcto.',
            'monto_adelanto_1.min' => 'Rangos desde 1 hasta 99,999,999.',
            'monto_adelanto_1.max' => 'Rangos desde 1 hasta 99,999,999.',
            'fecha_desde_adelanto_2.required' => 'Ingrese Fecha.',
            'fecha_hasta_adelanto_2.required' => 'Ingrese Fecha.',
            'monto_adelanto_2.required' => 'Ingrese monto.',
            'monto_adelanto_2.numeric' => 'Ingrese monto correcto.',
            'monto_adelanto_2.min' => 'Rangos desde 1 hasta 99,999,999.',
            'monto_adelanto_2.max' => 'Rangos desde 1 hasta 99,999,999.',
        ];
    }
}
