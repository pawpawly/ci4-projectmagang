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
            'PASSWORD_USER' => password_hash('1', PASSWORD_BCRYPT), // Password default
            'LEVEL_USER'    => '2', // Role superadmin
            'USER_TOKEN'    => bin2hex(random_bytes(16)), // Token unik
        ];

        // Insert data ke tabel user
        $this->db->table('user')->insert($data);
    }
}
