<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActifsFinanciersControllers extends Controller
{
    //
    public function index(){
        $list_actifs = DB::table('actifs_financiers')
            ->get();
        return view('actifs',compact('list_actifs'));
    }

    public function insert(Request $request){
        $nom = $request->input('nom');
        $symbole_boursier = $request->input('symbole_boursier');
        $categorie = $request->input('categorie');

        $insert = DB::table('actifs_financiers')->insert([
            'nom' => $nom,
            'symbole_boursier' => $symbole_boursier,
            'categorie' => $categorie,
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
            DB::table('actifs_financiers')
                ->where('id_actifs_financiers','=',$item)
                ->delete();
        }
        Session()->flash('success',"Suppression effectuée avec success.");
        return redirect()->back();
    }

    public function update($id,Request $request){
        $nom = $request->input('nom');
        $symbole_boursier = $request->input('symbole_boursier');
        $categorie = $request->input('categorie');

        $insert = DB::table('actifs_financiers')->where("id_actifs_financiers",'=',$id)->update([
            'nom' => $nom,
            'symbole_boursier' => $symbole_boursier,
            'categorie' => $categorie,
        ]);

        if ($insert){
            Session()->flash('success',"Modification effectuée avec success.");
        }else{
            Session()->flash('error',"Erreur lors de la modification.");
        }
        return redirect()->back();
    }

    public function edit($id){
        $list_actifs = DB::table('actifs_financiers')
            ->get();
        $position = DB::table('actifs_financiers')->where("id_actifs_financiers",'=',$id)
            ->first();
        return view('actifs',compact('list_actifs','position'));
    }
}
