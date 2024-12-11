<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class CreateDatabase extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'db:create';
    protected $description = 'Membuat database baru.';

    public function run(array $params)
    {
        $forge = Database::forge();

        // Nama database yang ingin dibuat
        $dbName = 'museum_db';

        CLI::write("Membuat database '{$dbName}'...", 'yellow');

        // Periksa dan buat database
        if ($forge->createDatabase($dbName, true)) {
            CLI::write("Database '{$dbName}' berhasil dibuat.", 'green');
        } else {
            CLI::error("Database '{$dbName}' sudah ada atau terjadi kesalahan.");
        }
    }
}
