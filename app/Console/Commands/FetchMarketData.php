<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class   FetchMarketData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-market-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $stopLossSymboles =  DB::table('stop_loss')
            ->join('actifs_financiers', 'stop_loss.actif_financier_id', '=', 'actifs_financiers.id_actifs_financiers')
            ->select('stop_loss.id_stop_loss', 'actifs_financiers.nom', 'stop_loss.niveau_stop_loss', 'stop_loss.niveau_declenchement', 'stop_loss.etat')
            ->where('utilisateur_id', '=', 1)
            ->where('etat', '=', 'active')
            ->get();
        foreach ($stopLossSymboles as $stopLossSymbole){
            $response = Http::get('https://www.alphavantage.co/query', [
                'function' => 'GLOBAL_QUOTE',
                'symbol' => $stopLossSymbole->symbole_boursier, // Replace with the symbol you want to track
                'apikey' => "R9B39IM9M5LG0HG2",
            ]);
            if ($response->ok()) {
                $data = $response->json()['Global Quote'];
                DB::table("actifs_financiers_montant")
                    ->insert(array(
                        'symbole_boursier' => $data['01. symbol'],
                        'montant' => $data['05. price'],
                    ));
            } else {
                $this->error('Failed to fetch market data: '.$response->status());
            }
        }

    }
}
