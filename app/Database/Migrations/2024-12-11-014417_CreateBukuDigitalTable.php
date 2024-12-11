<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBukuDigitalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_BUKU' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'JUDUL_BUKU' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'PENULIS_BUKU' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => false,
            ],
            'TAHUN_BUKU' => [
                'type'       => 'YEAR',
                'constraint' => 4,
                'null'       => false,
            ],
            'SINOPSIS_BUKU' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'SAMPUL_BUKU' => [
                'type' => 'BLOB',
                'null' => true,
            ],
            'PRODUK_BUKU' => [
                'type' => 'BLOB',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('ID_BUKU', true); // PRIMARY KEY
        $this->forge->createTable('bukudigital');
    }

    public function down()
    {
        $this->forge->dropTable('bukudigital');
    }
}
