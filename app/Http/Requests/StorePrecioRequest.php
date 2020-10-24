<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrecioRequest extends FormRequest
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
            'codigoGenerate' => 'unique:precio,codigoGenerate',
            'precioCompra' => 'numeric|min:0|max:99999',
            'precioVenta' => 'numeric|min:'.$this->precioCompra.'|max:99999',
        ];
    }
    public function messages(){
        return [
            'codigoGenerate.unique' => 'Se repiten los valores en los parámetros.',
            'precioVenta.min' => 'Evite pérdidas.',
        ];
    }
}
