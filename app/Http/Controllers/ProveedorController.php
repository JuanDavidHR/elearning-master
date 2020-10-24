<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ProveedorStoreRequest;
use App\Http\Requests\ProveedorUpdateRequest;
use App\Proveedor;
use App\Persona;



class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $proveedores = Persona::select('entidad.id', 'entidad.nombre', 'entidad.num_documento', 'entidad.vigencia')
        ->orderby('entidad.nombre', 'asc')
        ->where('entidad.num_documento', '!=', '00000000')
        ->paginate(5);
        return [
            'pagination' => [
                'total'        => $proveedores->total(),
                'current_page' => $proveedores->currentPage(),
                'per_page'     => $proveedores->perPage(),
                'last_page'    => $proveedores->lastPage(),
                'from'         => $proveedores->firstItem(),
                'to'           => $proveedores->lastItem(),
            ],
            'proveedores' => $proveedores
        ];
    }

    public function store(ProveedorStoreRequest $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombre = $request->nombre;            
            $persona->num_documento = $request->num_documento;
            $persona->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function update(ProveedorUpdateRequest $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();            
            $persona = Persona::findOrFail($request->id);
            $persona->nombre = $request->nombre;
            $persona->num_documento = $request->num_documento;
            $persona->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }
    public function selectProveedor(Request $request){
        if (!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $proveedores = Proveedor::join('personas', 'proveedores.id', '=', 'personas.id')
        ->where('personas.nombre', 'like', '%'.$filtro.'%')
        ->orWhere('personas.num_documento', 'like', '%'.$filtro.'%')
        ->select('personas.id', 'personas.nombre', 'personas.num_documento')
        ->orderby('personas.nombre', 'asc')
        ->limit(3)
        ->get();
        return ['Proveedores'=>$proveedores];
    }
    public function getProveedor(Request $request){
        if (!$request->ajax()) return redirect('/');
        $proveedores = Proveedor::join('entidad', 'proveedores.id', '=', 'entidad.id')
        ->select('entidad.id', 'entidad.nombre', 'entidad.num_documento')
        ->orderby('entidad.nombre', 'asc')
        ->where('entidad.tipo_entidad', '=', 'Persona')
        ->get();
        return ['proveedor'=>$proveedores];
    }
    public function disabled(Request $request){
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $persona = Persona::findOrFail($request->id);
            $persona->vigencia = 0;
            $persona->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }
    public function enabled(Request $request){
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $persona = Persona::findOrFail($request->id);
            $persona->vigencia = 1;
            $persona->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }
}
