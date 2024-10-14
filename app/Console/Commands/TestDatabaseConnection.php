<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Exception;

class TestDatabaseConnection extends Command
{
    protected $signature = 'db:test';
    protected $description = 'Test de la base de donnée ';

    public function handle()
    {
        try {
            DB::connection()->getPdo();
            $this->info('la connexion à la base de donnée fonctionne.');
        } catch (Exception $e) {
            $this->error('Connexion à la base de donnée impossible veuiller vérifier vos configuaration: ' . $e->getMessage());
        }
    }
}
