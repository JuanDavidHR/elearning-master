<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Persona;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $personas = User::join('personas', 'users.id', '=', 'personas.id')
            ->join('roles', 'users.idRoles', '=', 'roles.idRoles')
            ->select('personas.id', 'personas.nombre', 'personas.tipo_documento',
            'personas.num_documento', 'personas.direccion', 'personas.telefono',
            'personas.email', 'users.usuario', 'users.password', 'users.vigencia', 'users.idRoles', 'roles.nombre as rol')
            ->orderBy('personas.id', 'desc')
            ->paginate(5);
        }
        else{
            $personas = User::join('personas', 'users.id', '=', 'personas.id')
            ->join('roles', 'users.idRoles', '=', 'roles.idRoles')
            ->select('personas.id', 'personas.nombre', 'personas.tipo_documento',
            'personas.num_documento', 'personas.direccion', 'personas.telefono',
            'personas.email', 'users.usuario', 'users.password', 'users.vigencia', 'users.idRoles', 'roles.nombre as rol')
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('personas.id', 'desc')
            ->paginate(5);
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

    public function store(UserStoreRequest $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();
            $user =  new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->vigencia = '1';
            $user->idRoles = $request->idRoles;
            $user->id = $persona->id;
            $user->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        
    }

    public function update(UserUpdateRequest $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();

            //$proveedor = Proveedor::where('idPersona',$request->idPersona)->firstOrFail();
            $user = User::findOrFail($request->idPersona);
            $persona = Persona::findOrFail($user->id);
            $persona->nombre = $request->nombre;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();

            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->vigencia = '1';
            $user->idRoles = $request->idRoles;
            $user->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->idPersona);//accedemos a cada una de las propiedades
        $user->vigencia = '0';
        $user->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->idPersona);//accedemos a cada una de las propiedades
        $user->vigencia = '1';
        $user->save();
    }
}
