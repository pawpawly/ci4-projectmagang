<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'USERNAME'      => 'superadmin',
            'NAMA_USER'     => 'superadminTest',
            'PASSWORD_USER' => password_hash('1', PASSWORD_BCRYPT),
            'LEVEL_USER'    => '2',
        ];

        // Insert data ke tabel user
        $this->db->table('user')->insert($data);
    }
}
