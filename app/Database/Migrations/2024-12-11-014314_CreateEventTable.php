<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_EVENT' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ID_KEVENT' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'USERNAME' => [
                'type'       => 'CHAR',
                'constraint' => 64,
                'null'       => false,
            ],
            'NAMA_EVENT' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'DEKSIRIPSI_EVENT' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'TANGGAL_EVENT' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'JAM_EVENT' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'FOTO_EVENT' => [
                'type' => 'LONGBLOB',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('ID_EVENT', true); // PRIMARY KEY
        $this->forge->createTable('event');
    }

    public function down()
    {
        $this->forge->dropTable('event');
    }
}
