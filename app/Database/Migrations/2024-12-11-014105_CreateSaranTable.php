<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSaranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_SARAN' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'NAMA_SARAN' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'EMAIL_SARAN' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'KOMENTAR_SARAN' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'TANGGAL_SARAN' => [
                'type'    => 'DATETIME',
                'null'    => false,
            ],
        ]);

        $this->forge->addKey('ID_SARAN', true); // PRIMARY KEY
        $this->forge->createTable('saran');
    }

    public function down()
    {
        $this->forge->dropTable('saran');
    }
}
