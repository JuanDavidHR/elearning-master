<?php

namespace App\Http\Controllers;
use App\Precio;
use App\detallePrecio;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\StorePrecioRequest;
use App\Http\Requests\UpdatePrecioRequest;


class PrecioController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $precios = Precio::select('idPrecio', 'codigoGenerate', 'precioCompra', 'precioVenta', 'c', 'h', 'r', 'unidad')
        ->orderBy('codigoGenerate', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $precios->total(),
                'current_page'      => $precios->currentPage(),
                'per_page'          => $precios->perPage(),
                'last_page'         => $precios->lastPage(),
                'from'              => $precios->firstItem(),
                'to'                => $precios->lastItem(),
            ], 'precios' => $precios
        ];
    }
    public function buscar(Request $request){
        $precios = Precio::select('precioCompra')->where('codigoGenerate', '=', $request->codigo)->get();
        return $precios;
    }
    public function store(StorePrecioRequest $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $precio = new Precio();
            $precio->codigoGenerate = $request->codigoGenerate;
            $precio->precioCompra = $request->precioCompra;
            $precio->precioVenta = $request->precioVenta;
            $precio->c = $request->cascara;
            $precio->r = $request->rendimiento;
            $precio->h = $request->humedad;
            $precio->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function update(UpdatePrecioRequest $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $precio = Precio::findOrFail($request->idPrecio);
            $precio->codigoGenerate = $request->codigoGenerate;
            $precio->precioCompra = $request->precioCompra;
            $precio->precioVenta = $request->precioVenta;
            $precio->c = $request->cascara;
            $precio->h = $request->humedad;
            $precio->r = $request->rendimiento;
            $precio->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}

