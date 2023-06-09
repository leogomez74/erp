<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('checkInvoice')->dailyAt('07:00')->timezone('America/Costa_Rica');
        $schedule->command('checkCharges')->dailyAt('08:00')->timezone('America/Costa_Rica');
        $schedule->command('facturasVencidas')->dailyAt('08:00')->timezone('America/Costa_Rica');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
