<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBukuTamuTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_TAMU' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'NAMA_TAMU' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'TIPE_TAMU' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'null'       => false,
            ],
            'ALAMAT_TAMU' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'NOHP_TAMU' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'null'       => false,
            ],
            'TGLKUNJUNGAN_TAMU' => [
                'type'    => 'DATETIME',
                'null'    => false,
            ],
            'FOTO_TAMU' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'JKL_TAMU' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'JKP_TAMU' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('ID_TAMU', true); // PRIMARY KEY
        $this->forge->createTable('bukutamu');
    }

    public function down()
    {
        $this->forge->dropTable('bukutamu');
    }
}
