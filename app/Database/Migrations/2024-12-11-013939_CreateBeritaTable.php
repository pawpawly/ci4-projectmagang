<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBeritaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_BERITA' => [
                'type'           => 'INT',
                'constraint'     => 64,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'PENYIAR_BERITA' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'NAMA_BERITA' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'DESKRIPSI_BERITA' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'SUMBER_BERITA' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'TANGGAL_BERITA' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'FOTO_BERITA' => [
                'type' => 'LONGBLOB',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('ID_BERITA', true); // PRIMARY KEY
        $this->forge->createTable('berita');
    }

    public function down()
    {
        $this->forge->dropTable('berita');
    }
}
