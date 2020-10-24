<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaUpdateRequest extends FormRequest
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

    /*,
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //funciona así xd pero a la hora de que quiere cambiar y poner el nombre igual no bota mensaje que debría de botar
        //'nombreCategoria' => 'required|unique:categorias,nombreCategoria,NULL,id,idCategoria,'.$this->idCategoria   , 
        //'nombreCategoria' => 'required|unique:categorias,nombreCategoria,' .$this->idCategoria. ',idCategoria',
        return [
            'nombre' => 'required|unique:categoria,nombre,' .$this->idCategoria. ',idCategoria',
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la Categoría es Requerido',
            'nombre.unique'  => 'El nombre de la Categoría ya se encuentra en uso',
        ];
    }
}
