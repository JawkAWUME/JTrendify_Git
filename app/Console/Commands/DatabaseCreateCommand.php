<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DatabaseCreateCommand extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Créer la base de données définie dans le fichier .env';

    public function handle()
    {
        $database = Config::get('database.connections.mysql.database');
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');
        $host = Config::get('database.connections.mysql.host');

        Config::set('database.connections.mysql.database', null);

        try {
            $pdo = new \PDO("mysql:host=$host", $username, $password);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $this->info("Base de données '$database' créée avec succès !");
        } catch (\PDOException $e) {
            $this->error("Erreur lors de la création de la base de données : " . $e->getMessage());
        }
    }
}
