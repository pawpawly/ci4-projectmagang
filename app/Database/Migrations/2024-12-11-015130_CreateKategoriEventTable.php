<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategoriEventTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_KEVENT' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'KATEGORI_KEVENT' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'DESKRIPSI_KEVENT' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('ID_KEVENT', true); // PRIMARY KEY
        $this->forge->createTable('kategori_event');
    }

    public function down()
    {
        $this->forge->dropTable('kategori_event');
    }
}
