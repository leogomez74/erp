<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;

class checkInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkInvoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica facturas vencidas actualizar su estatus a vencidas';

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
     *
     * @return int
     */
    public function handle()
    {
        $vencidas = Invoice::whereNotIn("status",[3,4,5])->where("due_date","<",now()->format("Y-m-d"));

       if ($vencidas->count() >0){
           $vencidas->update(['status' => 5]);
       }
    }
}
