<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ViaticoUpdateRequest extends FormRequest
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
            'idArea' => 'not_in:0',
            'documento_solicitud' => 'string|required|unique:viatico,documento_solicitud,'.$this->idViatico.',idViatico|min:5|max:90',
            'documento_autorizacion' => 'string|required|unique:viatico,documento_autorizacion,'.$this->idViatico.',idViatico|min:5|max:90',
            'nombre_responsable' => 'string|required|min:5|max:90',
            'monto_viatico' => 'required|numeric|min:1|max:99999999',
            'fecha_solicitud'=> 'required',
            'fecha_autorizacion'=> 'required',
            'fecha_inicio'=> 'required',
            'fecha_final'=> 'required',
            'fecha_maximo'=> 'required',
        ];
    }
    public function messages(){
        return [
            'idArea.not_in' => 'Seleccione un Área.',
            'documento_solicitud.unique' => 'El documento ya se encuentra registrado.',
            'documento_solicitud.string' => 'Ingrese el documento.',
            'documento_solicitud.required' => 'Ingrese el documento.',
            'documento_solicitud.min' => 'Se permiten de 5 a 90 caracteres.',
            'documento_solicitud.max' => 'Se permiten de 5 a 90 caracteres.',
            'documento_autorizacion.unique' => 'El documento ya se encuentra registrado.',
            'documento_autorizacion.string' => 'Ingrese el documento.',
            'documento_autorizacion.required' => 'Ingrese el documento.',
            'documento_autorizacion.min' => 'Se permiten de 5 a 90 caracteres.',
            'documento_autorizacion.max' => 'Se permiten de 5 a 90 caracteres.',
            'nombre_responsable.string' => 'Ingrese nombre.',
            'nombre_responsable.required' => 'Ingrese nombre.',
            'nombre_responsable.min' => 'Se permiten de 5 a 90 caracteres.',
            'nombre_responsable.max' => 'Se permiten de 5 a 90 caracteres.',
            'fecha_solicitud.required' => 'Ingrese Fecha.',
            'fecha_autorizacion.required' => 'Ingrese Fecha.',
            'fecha_inicio.required' => 'Ingrese Fecha.',
            'fecha_final.required' => 'Ingrese Fecha.',
            'monto_viatico.required' => 'Ingrese monto.',
            'monto_viatico.numeric' => 'Ingrese monto correcto.',
            'monto_viatico.min' => 'Rangos desde 1 hasta 99,999,999.',
            'monto_viatico.max' => 'Rangos desde 1 hasta 99,999,999.',
        ];
    }
}
