<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ScrapingWiijob::class,
        Commands\ScrapingExpatDakar::class,
        Commands\TestDatabaseConnection::class,
        Commands\ScrapingRecrutementSN::class,
        Commands\ExtraireProfil::class,
        Commands\NettoyerDescription::class,
// Ajoutez d'autres commandes personnalisées ici
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Définissez ici les tâches planifiées avec $schedule
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        // Requirez des commandes externes si nécessaire
        // $this->load(__DIR__.'/path/to/your/commands');

        // $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}