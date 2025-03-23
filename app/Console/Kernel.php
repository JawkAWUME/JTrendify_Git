<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Les commandes Artisan de l'application.
     *
     * @var array
     */
    protected $commands = [
        // Enregistre ta commande ici
        \App\Console\Commands\DatabaseCreateCommand::class,
    ];

    /**
     * Définir l'ordonnancement des tâches.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Planifie les tâches ici
    }

    /**
     * Définir les ressources de console.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
