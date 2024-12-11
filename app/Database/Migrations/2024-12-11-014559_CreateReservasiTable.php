<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReservasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_RESERVASI' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'NAMA_RESERVASI' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'INSTANSI_RESERVASI' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'EMAIL_RESERVASI' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'TELEPON_RESERVASI' => [
                'type'       => 'CHAR',
                'constraint' => 15,
                'null'       => false,
            ],
            'JMLPENGUNJUNG_RESERVASI' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'KEGIATAN_RESERVASI' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'TANGGAL_RESERVASI' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'SURAT_RESERVASI' => [
                'type' => 'LONGBLOB',
                'null' => true,
            ],
            'STATUS_RESERVASI' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'Pending',
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('ID_RESERVASI', true); // PRIMARY KEY
        $this->forge->createTable('reservasi');
    }

    public function down()
    {
        $this->forge->dropTable('reservasi');
    }
}
