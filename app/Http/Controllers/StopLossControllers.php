<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StopLossControllers extends Controller
{
    //
    public function index(){
        $stops = DB::table('stop_loss')
            ->join('actifs_financiers', 'stop_loss.actif_financier_id', '=', 'actifs_financiers.id_actifs_financiers')
            ->select('stop_loss.id_stop_loss', 'actifs_financiers.nom', 'stop_loss.niveau_stop_loss', 'stop_loss.niveau_declenchement', 'stop_loss.etat')
            ->where('utilisateur_id', '=', 1)
            ->get();
        $list_actifs = DB::table('actifs_financiers')->orderBy("id_actifs_financiers", "ASC")->pluck("nom","id_actifs_financiers");
        return view('stop',compact('stops','list_actifs'));
    }
}
