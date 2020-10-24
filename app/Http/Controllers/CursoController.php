<?php

namespace App\Http\Controllers;

use App\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $cursos = Curso::select('id', 'nombreCurso', 'fechaCurso', 'horasCurso')
        ->orderBy('id', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $cursos->total(),
                'current_page'      => $cursos->currentPage(),
                'per_page'          => $cursos->perPage(),
                'last_page'         => $cursos->lastPage(),
                'from'              => $cursos->firstItem(),
                'to'                => $cursos->lastItem(),
            ], 'cursos' => $cursos
        ];
    }
    
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $curso = new Curso();
            $curso->nombreCurso = $request->nombreCurso;
            $curso->fechaCurso = $request->fechaCurso;
            $curso->horasCurso = $request->horasCurso;
            $curso->save();
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
            $curso = Curso::findOrFail($request->id);
            $curso->nombreCurso = $request->nombreCurso;
            $curso->fechaCurso = $request->fechaCurso;
            $curso->horasCurso = $request->horasCurso;
            $curso->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

}
