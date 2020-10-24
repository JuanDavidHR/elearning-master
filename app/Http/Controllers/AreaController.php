<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
class AreaController extends Controller
{
    public function selectArea(Request $request){ 
        if(!$request->ajax()) return redirect('/');
            $area = Area::where('vigencia', '=', '1')->
            select('idArea', 'nombre')->
            orderBy('idArea', 'asc')->get();
        return ['areas' => $area];
    }
}
