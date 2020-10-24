<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupo;

class GrupoController extends Controller
{
    public function update(GrupoUpdateRequest $request)
    {
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $grupos = Grupo::findOrFail($request->idGrupos);
            $grupos->descripcion = $request->descripcion;
            $directo->fecha_remision = $request->fecha_remision;
            $directo->fecha_recepcion = $request->fecha_recepcion;
            $directo->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
