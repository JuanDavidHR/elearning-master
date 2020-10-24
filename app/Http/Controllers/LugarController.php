<?php

namespace App\Http\Controllers;

use App\Lugar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LugarController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $lugares = Lugar::select('id', 'lugarCapacitacion')
        ->orderBy('id', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $lugares->total(),
                'current_page'      => $lugares->currentPage(),
                'per_page'          => $lugares->perPage(),
                'last_page'         => $lugares->lastPage(),
                'from'              => $lugares->firstItem(),
                'to'                => $lugares->lastItem(),
            ], 'lugares' => $lugares
        ];
    }
    
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $lugar = new Lugar();
            $lugar->lugarCapacitacion = $request->lugarCapacitacion;
            $lugar->save();
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
            $lugar = Lugar::findOrFail($request->id);
            $lugar->lugarCapacitacion = $request->lugarCapacitacion;
            $lugar->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
