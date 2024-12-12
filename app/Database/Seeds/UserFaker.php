<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;
use CodeIgniter\I18n\Time;

class UserFaker extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID'); // Menggunakan bahasa Indonesia

        $data = [];
        
        for ($i = 0; $i < 50; $i++) {
            $data[] = [
                'USERNAME' => $faker->unique()->userName,
                'NAMA_USER' => $faker->name,
                'PASSWORD_USER' => password_hash('12345678', PASSWORD_DEFAULT),
                'LEVEL_USER' => $faker->numberBetween(1, 2),
            ];
        }

        // Insert data ke database
        $this->db->table('user')->insertBatch($data);
    }
}
