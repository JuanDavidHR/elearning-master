<?php

namespace App\Http\Controllers;
use App\Parametro;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\ParametroStoreRequest;
use App\Http\Requests\ParametroUpdateRequest;

class ParametroController extends Controller
{
    public function index(Request $request){
        $parametros = Parametro::orderBy('idParametro', 'asc')->get();
        return ['parametros'=> $parametros];
    }
    public function store(ParametroStoreRequest $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $parametro = new Parametro();
            $parametro->nombreParametro = $request->nombreParametro;
            $parametro->inicialParametro = $request->inicialParametro;
            $parametro->minParametro = $request->minParametro;
            $parametro->maxParametro = $request->maxParametro;
            $parametro->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function update(ParametroUpdateRequest $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $parametro = Parametro::findOrFail($request->idParametro);
            $parametro->nombreParametro = $request->nombreParametro;
            $parametro->inicialParametro = $request->inicialParametro;
            $parametro->minParametro = $request->minParametro;
            $parametro->maxParametro = $request->maxParametro;
            $parametro->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
