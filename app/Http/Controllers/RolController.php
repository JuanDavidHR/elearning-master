<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;

class RolController extends Controller
{
    public function selectRol(Request $request){ 
        if(!$request->ajax()) return redirect('/');
            $roles = Rol::where('vigencia', '=', '1')->
            select('idRoles', 'nombre')->
            orderBy('nombre', 'asc')->get();
            return ['roles' => $roles];
    }
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar ==''){
            $roles = Rol::orderBy('idRoles', 'desc')->paginate(5);
        }else{
            if($criterio == 'todo'){
                $roles = Rol::where('nombre', 'like', '%'.$buscar.'%')->orwhere('descripcion', 'like', '%'.$buscar.'%')->orderBy('idRoles', 'desc')->paginate(5);
            }else {
                $roles = Rol::where($criterio, 'like', '%'.$buscar.'%')->orderBy('idRoles', 'desc')->paginate(5);
            }
        } 
        return [
            'pagination' => [
                'total'             => $roles->total(),
                'current_page'      => $roles->currentPage(),
                'per_page'          => $roles->perPage(),
                'last_page'         => $roles->lastPage(),
                'from'              => $roles->firstItem(),
                'to'                => $roles->lastItem(),
            ], 'roles' => $roles
        ];
    }
    public function store(CategoriaStoreRequest $request)
    {   
        if(!$request->ajax()) return redirect('/');
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->vigencia = '1';
        $categoria->save();
    }
    public function update(CategoriaUpdateRequest $request)
    {
        if(!$request->ajax()) return redirect('/');
        $categoria = Categoria::findOrFail($request->idCategoria);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->vigencia = $request->vigencia;
        $categoria->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $categoria = Categoria::findOrFail($request->idCategoria);
        $categoria->vigencia = '0';
        $categoria->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $categoria = Categoria::findOrFail($request->idCategoria);
        $categoria->vigencia = '1';
        $categoria->save();
    }
}