<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiDataControllers extends Controller
{
    //
    public function fetchInfo(){
        $list_actifs = DB::table('actifs_financiers')->orderBy("id_actifs_financiers", "ASC")->get();
        return response()->json($list_actifs);
    }
}
