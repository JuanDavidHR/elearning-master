<?php

namespace App\Http\Controllers;

use App\Escuela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EscuelaController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $escuelas = Escuela::select('id', 'nombreEscuela', 'siglas')
        ->orderBy('id', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $escuelas->total(),
                'current_page'      => $escuelas->currentPage(),
                'per_page'          => $escuelas->perPage(),
                'last_page'         => $escuelas->lastPage(),
                'from'              => $escuelas->firstItem(),
                'to'                => $escuelas->lastItem(),
            ], 'escuelas' => $escuelas
        ];
    }
    
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $escuela = new Escuela();
            $escuela->nombreEscuela = $request->nombreEscuela;
            $escuela->siglas = $request->siglas;            
            $escuela->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function update(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $escuela = Escuela::findOrFail($request->id);
            $escuela->nombreEscuela = $request->nombreEscuela;
            $escuela->siglas = $request->siglas;            
            $escuela->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
