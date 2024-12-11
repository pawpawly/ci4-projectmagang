<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategoriKoleksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_KKOLEKSI' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'KATEGORI_KKOLEKSI' => [
                'type'       => 'CHAR',
                'constraint' => 64,
                'null'       => false,
            ],
            'DESKRIPSI_KKOLEKSI' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('ID_KKOLEKSI', true); // PRIMARY KEY
        $this->forge->createTable('kategori_koleksi');
    }

    public function down()
    {
        $this->forge->dropTable('kategori_koleksi');
    }
}
