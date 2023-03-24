<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GetMarketData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-market-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function sendAlert($symbole,$stopLoss,$id_stop_loss,$prix_trading):void{
        $marketData =  DB::table('historique_transactions')
            ->join('actifs_financiers', 'historique_transactions.actif_financier_id', '=', 'actifs_financiers.id_actifs_financiers')
            ->where("actifs_financiers.symbole_boursier","=",$symbole)
            ->where("historique_transactions.utilisateur_id","=",1)
            ->orderBy('date_transaction', 'desc')
            ->limit(1)
            ->first();

        if ($marketData) {


            $buyPrice = $marketData->prix;
            // Calculer le stop-loss
            $stopLossPrice = $buyPrice - ($buyPrice * $stopLoss);

            if ($prix_trading <= $stopLossPrice) {

                $alert = DB::table("alertes")
                    ->insert(array(
                        "stop_loss_id"=>$id_stop_loss,
                        "type_alerte"=>"sms",
                        "destinataire"=>"2250143148561",
                    ))
                ;

                $active = DB::table('stop_loss')
                    ->where('id_stop_loss','=',$id_stop_loss)
                    ->update(array(
                        "etat"=>"desactive"
                    ));
            }


        }
    }

    public function handle(): void
    {
        $stopLossSymboles =  DB::table('stop_loss')
            ->join('actifs_financiers', 'stop_loss.actif_financier_id', '=', 'actifs_financiers.id_actifs_financiers')
            ->where('utilisateur_id', '=', 1)
            ->where('etat', '=', 'active')
            ->get();

        foreach ($stopLossSymboles as $stopLossSymbole){
            $client = new Client();
            $response = $client->request('GET', 'https://www.alphavantage.co/query', [
                'query' => [
                    'function' => 'GLOBAL_QUOTE',
                    'symbol' =>  $stopLossSymbole->symbole_boursier,
                    'apikey' =>  "R9B39IM9M5LG0HG2",
                ]
            ]);
            $data = json_decode($response->getBody(), true);
            $symbole =   $data['Global Quote']['01. symbol'];
            $currentPrice = $data['Global Quote']['05. price'];
            $stopLossPourcentage = round($stopLossSymbole->niveau_stop_loss/100,3);
            $id_stop_loss = $stopLossSymbole->id_stop_loss;
            $this->sendAlert($symbole,$stopLossPourcentage,$id_stop_loss,$currentPrice);
            DB::table("actifs_financiers_montant")
                ->insert(array(
                    'symbole_boursier' => $symbole,
                    'montant' => (float)$currentPrice,
                ));


        }

    }
}
