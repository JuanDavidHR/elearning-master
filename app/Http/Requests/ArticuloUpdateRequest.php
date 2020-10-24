<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticuloUpdateRequest extends FormRequest
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
            'nombre' => 'required|unique:producto,nombre,' .$this->idProducto. ',idProducto',
            'codigoProducto' => 'required|unique:producto,codigoProducto,' .$this->idProducto. ',idProducto',
            'precioVenta' => 'required|numeric',
            'precioCompra' => 'required|numeric|min:0|max:99999',
            'idCategoria' => 'not_in:0',
            'precioVenta' => 'numeric|min:'.$this->precioCompra.'|max:99999',
            'precioMayor' => 'numeric|min:'.$this->precioCompra.'|max:'.$this->precioVenta.'|between:0,99999.99',
            'stockMinimo' => 'required|integer|min:0|max:99999',
            'descripcion' => 'min:0|max:100'
        ];
    }
    public function messages()
    {
        return [
            'descripcion.max' => 'Máximo 100 dígitos.',
            'stockMinimo.required' => 'Ingrese el código.',
            'stockMinimo.min' => 'Números de 0 a 99999.',
            'stockMinimo.max' => 'Números de 0 a 99999.',
            'codigoProducto.required' => 'Ingrese el código.',
            'codigoProducto.min' => 'Se admiten de 6-20 dígitos.',
            'codigoProducto.max' => 'Se admiten de 6-20 dígitos.',
            'codigoProducto.unique' => 'El código ya se encuentra en uso.',
            'nombre.string'  => 'Ingrese el nombre.',
            'nombre.required'  => 'Ingrese el nombre.',
            'nombre.unique'  => 'El nombre ya se encuentra en uso.',
            'nombre.min' => 'Se admiten de 3-20 dgitos.',
            'nombre.max' => 'Se admiten de 3-20 dgitos.',
            'precioVenta.numeric' => 'Ingrese precio de venta.',
            'precioVenta.required' => 'Ingrese precio de venta.',
            'precioVenta.max' => 'Números de 0 a 99999.99.',
            'precioCompra.max' => 'Números de 0 a 99999.99.',
            'precioVenta.between' => 'Números de 0 a 99999.99.',
            'precioCompra.required' => 'Ingrese precio de compra.',
            'precioCompra.min' => 'Ingrese un precio válido.',
            'idCategoria.not_in' => 'Seleccione una categoría.',
            'precioVenta.min' => 'El monto no debe de ser menor que el precio de compra.',
            'precioMayor.required' => 'Ingrese precio al por mayor.',
            'precioMayor.numeric' => 'Ingrese precio al por mayor.',
            'precioMayor.min' => 'El precio al por mayor no debe de ser menor que el precio de compra.',
            'precioMayor.max' => 'El precio al por mayor no debe de ser menor que el precio de venta.',

        ];
    }
}
