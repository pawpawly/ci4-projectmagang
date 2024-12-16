<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'USERNAME' => [
                'type'       => 'CHAR',
                'constraint' => 64,
                'null'       => false,
            ],
            'NAMA_USER' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'PASSWORD_USER' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'LEVEL_USER' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'null'       => false,
            ],
            'USER_TOKEN' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true, // Kolom USER_TOKEN dapat bernilai NULL
                'default'    => null,
            ],
        ]);

        $this->forge->addKey('USERNAME', true); // PRIMARY KEY
        $this->forge->createTable('user');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
