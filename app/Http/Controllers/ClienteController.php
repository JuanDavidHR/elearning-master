<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Http\Requests\PersonaCreateRequest;
use App\Http\Requests\PersonaUpdateRequest;

class ClienteController extends Controller
{
    public function selectCliente(Request $request){
        if (!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $clientes = Persona::where('nombre', 'like', '%'.$filtro.'%')
        ->orWhere('num_documento', 'like', '%'.$filtro.'%')
        ->select('id', 'nombre', 'num_documento')
        ->orderby('nombre', 'asc')
        ->limit(3)
        ->get();
        return ['clientes'=>$clientes]; 
    }
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $personas = Persona::orderBy('personas.id', 'desc')
            ->paginate(3);
        }
        else{
            $personas = Persona::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id', 'desc')
            ->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    public function store(PersonaCreateRequest $request)
    {
        if (!$request->ajax()) return redirect('/');
        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->num_documento = $request->num_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->save();
    }

    public function update(PersonaUpdateRequest $request)
    {
        if (!$request->ajax()) return redirect('/');
        $persona = Persona::findOrFail($request->idPersona);
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->num_documento = $request->num_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->vigencia = $request->vigencia;
        $persona->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $persona = Persona::findOrFail($request->idPersona);//accedemos a cada una de las propiedades
        $persona->vigencia = '0';
        $persona->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $persona = Persona::findOrFail($request->idPersona);//accedemos a cada una de las propiedades
        $persona->vigencia = '1';
        $persona->save();
    }
}
