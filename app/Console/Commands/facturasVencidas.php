<?php

namespace App\Console\Commands;

use App\Models\Charges;
use App\Models\Invoice;
use Gnumarquez\Whatsapp;
use Illuminate\Console\Command;

class facturasVencidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facturasVencidas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica facturas vencidas para generar cobros';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $total_amount = 0;
//        $waYoselin = "50686975829";
        $waMaria = '584124292141';
        $apiKey = '1FETR4zXAseHaQPNSBl2IWVwM60759ik'; //ssc number
        $data = [];
        $vencidas = Invoice::with('items')->where('status', 5)->where('due_date', '<', now()->format('Y-m-d'))->get();
        if ($vencidas->count() > 0) {
            //enviar maria
            $wa = new Whatsapp(false);
            $wa->apiKey = $apiKey;
            $wa->telf = $waMaria;
            $wa->txt = 'Existen cobros vencidos: https://erp2.ssc.cr/charges?status[0]=4';
            $wa->send();

            foreach ($vencidas as $vencida) {
                foreach ($vencida->items as $montos) {
                    $total_amount += $total_amount + ($montos->price * $montos->quantity) - $montos->discount;
                }
//                dd($total_amount);
                $data = [
                    'date' => now()->format('Y-m-d'),
                    'company' => 'Otro',
                    'charge_type' => 'Extraordinario',
                    'periodicity' => 'Una Vez',
                    'category' => 'Otro',
                    'amount' => $total_amount,
                    'observation' => ' cobro creado de factura en https://erp.ssc.cr/invoice/'.Crypt::encrypt($vencida->id),
                    'created_by' => 1,
                ];
                Charges::create($data);
            }
        }
    }
}
