<?php

namespace App\Console;

use App\Sucursal;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\App;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $sucursalService=App::make('SucursalService');
            $sucusales=Sucursal::all();
            \Log::info('Cerrando sucursales');
            foreach ($sucusales as $sucusal) {
                $sucursalService->cerrarCaja($sucusal->id);
            }
        })->dailyAt('23:50')->timezone('America/El_Salvador');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
