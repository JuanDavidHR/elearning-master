<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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

    public function rules()
    {
        return [
            'nombre' => 'string|required|min:5|max:25',
            'num_documento' => 'required|min:9999999|max:99999999|numeric|unique:entidad,num_documento,'.$this->idPersona.',id',
            'usuario' => 'required|min:5|max:20|unique:users,usuario,'.$this->idPersona.',id',
            'password' => 'string|required|min:5|max:20',
            'idRoles' => 'not_in:0',
            'email'=> 'required|email|min:3|max:40',
            'telefono' => 'required|min:100000000|max:1000000000000|numeric', 
        ];
    }
    public function messages(){
        return [
            'nombre.string' => 'Ingrese Nombre',
            'nombre.required' => 'Ingrese Nombre',
            'nombre.min' => 'Nombre debe de tener de 5 a 25 dígitos',
            'nombre.max' => 'Nombre debe de tener de 5 a 25 dígitos',
            'num_documento.string' => 'Ingrese DNI',
            'num_documento.required' => 'Ingrese DNI',
            'num_documento.min' => 'DNI debe de tener 8 dígitos',
            'num_documento.max' => 'DNI debe de tener 8 dígitos',
            'num_documento.unique' => 'DNI duplicado',
            'usuario.string' => 'Ingrese Usuario',
            'usuario.required' => 'Ingrese Usuario',
            'usuario.min' => 'Usuario debe de tener de 5 a 20 dígitos',
            'usuario.max' => 'Usuario debe de tener de 5 a 20 dígitos',
            'usuario.unique' => 'Usuario duplicado',
            'password.string' => 'Ingrese Password',
            'password.required' => 'Ingrese Password',
            'password.min' => 'Password debe de tener de 5 a 20 dígitos',
            'password.max' => 'Password debe de tener de 5 a 20 dígitos',
            'email.email' => 'Ingrese Email',
            'email.required' => 'Ingrese Email',
            'email.min' => 'Ingrese Email',
            'email.max' => 'Ingrese Email',
            'telefono.required' => 'Ingrese Teléfono',
            'telefono.numeric' => 'Ingrese Teléfono',
            'telefono.max' => 'Ingrese Teléfono'
        ];
    }
}
