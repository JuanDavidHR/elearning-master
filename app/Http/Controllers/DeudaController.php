<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deuda;

class DeudaController extends Controller
{
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $deuda = new Deuda();
            $date = Carbon::now('America/Lima');
            $deuda->numRecibo = $request->numRecibo;
            $deuda->fechaRegistro = $date;
            $deuda->montoTotal = $request->montoTotal;
            $deuda->montoCobrado = $request->montoCobrado;
            $deuda->montoDeuda = $request->montoDeuda;
            $deuda->descripcion = $request->descripcion;
            $deuda->vigencia = $request->vigencia;
            $deuda->save();
            DB::commit();
            return $deuda->idDeuda;
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
