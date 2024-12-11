<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKoleksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_KOLEKSI' => [
                'type'           => 'INT',
                'constraint'     => 64,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ID_KKOLEKSI' => [
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
            'NAMA_KOLEKSI' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'DESKRIPSI_KOLEKSI' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'FOTO_KOLEKSI' => [
                'type' => 'LONGBLOB',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('ID_KOLEKSI', true); // PRIMARY KEY
        $this->forge->addForeignKey('ID_KKOLEKSI', 'kategori_koleksi', 'ID_KKOLEKSI', 'CASCADE', 'CASCADE'); // Foreign Key
        $this->forge->createTable('koleksi');
    }

    public function down()
    {
        $this->forge->dropTable('koleksi');
    }
}
