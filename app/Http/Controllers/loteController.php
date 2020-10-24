<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Lote;
class LoteController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $lote = Lote::select('idLote', 'codigoLote', 'nombreLote', 'sacosLote', 'quintalesLote', 
        'taraLote', 'pesoNetoQuintal', 'cLote', 'rLote', 'hLote', 'precioNetoQuintal', 
        'quintalesPromedio', 'precioCompra', 'inversion', 'quintalesGanancia', 'precioVenta', 'ingresoVenta', 
        'estado')
        ->orderBy('idLote', 'asc')
        ->paginate(4);
        return [
            'pagination' => [
                'total'             => $lote->total(),
                'current_page'      => $lote->currentPage(),
                'per_page'          => $lote->perPage(),
                'last_page'         => $lote->lastPage(),
                'from'              => $lote->firstItem(),
                'to'                => $lote->lastItem(),
            ], 'lote' => $lote
        ];
    }
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $lote = new Lote();
            $lote->codigoLote = $request->codigoLote;
            $lote->nombreLote = $request->nombreLote;
            $lote->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
