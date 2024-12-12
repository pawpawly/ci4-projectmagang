<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory as Faker;

class SaranFaker extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 300; $i++) {
            $data = [
                'NAMA_SARAN'      => $faker->name,
                'EMAIL_SARAN'     => $faker->email,
                'KOMENTAR_SARAN'  => $faker->sentence(10), // 10 kata acak
                'TANGGAL_SARAN'   => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            ];

            $this->db->table('saran')->insert($data);
        }
    }
}
