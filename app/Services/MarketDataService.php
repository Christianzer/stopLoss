<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class MarketDataService
{
    public function process()
    {

        $stopLossSymboles =  DB::table('stop_loss')
            ->join('actifs_financiers', 'stop_loss.actif_financier_id', '=', 'actifs_financiers.id_actifs_financiers')
            ->select('stop_loss.id_stop_loss', 'actifs_financiers.nom', 'stop_loss.niveau_stop_loss', 'stop_loss.niveau_declenchement', 'stop_loss.etat')
            ->where('utilisateur_id', '=', 1)
            ->where('etat', '=', 'active')
            ->get();
        foreach ($stopLossSymboles as $stopLossSymbole){
            $marketData =  DB::table('actifs_financiers_montant')
                ->where("symbole_boursier","=",$stopLossSymbole->symbole_boursier)
                ->orderBy('date_creation', 'desc')->first();
            if ($marketData && $marketData->montant > $stopLossSymbole->niveau_stop_loss) {
                $alert = DB::table("alertes")
                    ->insert(array(
                        "stop_loss_id"=>$stopLossSymbole->id_stop_loss,
                        "type_alerte"=>"sms",
                        "destinataire"=>"2250143148561",
                    ))
                ;

                $active = DB::table('stop_loss')
                    ->where('id_stop_loss','=',$stopLossSymbole->id_stop_loss)
                    ->update(array(
                       "etat"=>"desactive"
                    ));

                if ($alert && $active) {
                    return 'Alert sent successfully.';
                } else {
                    return 'Failed to send alert: ';
                }
            }
        }

    }
}
