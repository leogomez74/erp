<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Gnumarquez\Whatsapp;
use App\Models\Charges;

class checkCharges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkCharges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica los cobros vencidos y envia alertas';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $waYoselin = "50686975829";
        $waMaria = "50670718888";
        $apiKey = "1FETR4zXAseHaQPNSBl2IWVwM60759ik"; //ssc number

        $porVencer = Charges::where("status",1)->where("date",now()->addDays(3)->format("Y-m-d"))->orWhere("day",now()->addDays(3)->format("d"));

        $venceHoy = Charges::where("status",1)->where("date",now()->format("Y-m-d"))->orWhere("day",now()->format("d"));

        $vencidas = Charges::where("status",1)->where("date","<",now()->format("Y-m-d"))->orWhere("day",now()->format("d"));

        if ($vencidas->count()>0){
            //enviar maria
            $vencidas->update(['status' => 4]);
            echo "hay vencidas ".$vencidas->count().PHP_EOL;
            $wa = new Whatsapp(false);
            $wa->apiKey = $apiKey;
            $wa->telf = $waMaria;
            $wa->txt = "Existen cobros vencidos: https://erp2.ssc.cr/charges?status[0]=4";
            $wa->send();
        }

        if ($venceHoy->count()>0){
            //enviar yos
            echo "hay vencen hoy ".$venceHoy->count().PHP_EOL;
            $wa = new Whatsapp(false);
            $wa->apiKey = $apiKey;
            $wa->telf = $waYoselin;
            $wa->txt = "Existen cobros que vencen hoy: https://erp2.ssc.cr/charges?status[0]=1";
            $wa->send();
        }

        if ($porVencer->count()>0){
            //enviar yos
            echo "vencen en 3 dias ".$porVencer->count();
            $wa = new Whatsapp(false);
            $wa->apiKey = $apiKey;
            $wa->telf = $waYoselin;
            $wa->txt = "Existen cobros a vencer dentro de 3 días: https://erp2.ssc.cr/charges?status[0]=1";
            $wa->send();
        }

        if (now()->format("d")==2){
            Payment::whereStatus(3)->update(["status"=>2]);
        }
        // $wa = new Whatsapp(false);
        // $wa->apiKey = $apiKey;
        // $wa->telf = "50670717777";
        // $wa->txt = $texto;
        // $wa->send();
    }
}
