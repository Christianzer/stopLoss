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

    public function create(Request $request){
        $actif_financier_id = $request->input('actif_financier_id');
        $niveau_stop_loss = $request->input('niveau_stop_loss');
        $niveau_declenchement = $request->input('niveau_declenchement');

        $insert = DB::table('stop_loss')->insert([
            'actif_financier_id' => $actif_financier_id,
            'niveau_stop_loss' => $niveau_stop_loss,
            'utilisateur_id' => 1,
            'niveau_declenchement' => $niveau_declenchement,
        ]);

        if ($insert){
            Session()->flash('success',"Enregistrement effectuée avec success.");
        }else{
            Session()->flash('error',"Erreur lors de l'enregistrement.");
        }

        return redirect()->back();
    }

    public function delete(Request $request){
        $cocher = $request->cocher;
        foreach ($cocher as $item){
            DB::table('stop_loss')
                ->where('id_stop_loss','=',$item)
                ->delete();
        }
        Session()->flash('success',"Suppression effectuée avec success.");
        return redirect()->back();
    }

    public function update($id,Request $request){
        $actif_financier_id = $request->input('actif_financier_id');
        $niveau_stop_loss = $request->input('niveau_stop_loss');
        $niveau_declenchement = $request->input('niveau_declenchement');

        $insert = DB::table('stop_loss')->where("id_stop_loss",'=',$id)->update([
            'actif_financier_id' => $actif_financier_id,
            'niveau_stop_loss' => $niveau_stop_loss,
            'utilisateur_id' => 1,
            'niveau_declenchement' => $niveau_declenchement,
        ]);

        if ($insert){
            Session()->flash('success',"Modification effectuée avec success.");
        }else{
            Session()->flash('error',"Erreur lors de la modification.");
        }
        return redirect()->back();
    }

    public function edit($id){
        $stops = DB::table('stop_loss')
            ->join('actifs_financiers', 'stop_loss.actif_financier_id', '=', 'actifs_financiers.id_actifs_financiers')
            ->select('stop_loss.id_stop_loss', 'actifs_financiers.nom', 'stop_loss.niveau_stop_loss', 'stop_loss.niveau_declenchement', 'stop_loss.etat')
            ->where('utilisateur_id', '=', 1)
            ->get();
        $position = DB::table('stop_loss')->where("id_stop_loss",'=',$id)
            ->first();
        $list_actifs = DB::table('actifs_financiers')->orderBy("id_actifs_financiers", "ASC")->pluck("nom","id_actifs_financiers");
        return view('stop',compact('stops','list_actifs','position'));

    }
}
