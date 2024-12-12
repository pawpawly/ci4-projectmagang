<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class BukuTamuFaker extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID'); // Menggunakan bahasa Indonesia

        $data = [];

        for ($i = 0; $i < 600; $i++) {
            $tipeTamu = $faker->numberBetween(1, 2);

            if ($tipeTamu === 1) {
                $jklTamu = $faker->numberBetween(0, 1); // 1 atau 0
                $jkpTamu = $jklTamu === 1 ? 0 : 1;   // Kebalikan dari JKL_TAMU
            } else {
                $jklTamu = $faker->numberBetween(1, 99);
                $jkpTamu = $faker->numberBetween(1, 99);
            }

            $data[] = [
                'NAMA_TAMU' => $faker->name,
                'TIPE_TAMU' => $tipeTamu,
                'ALAMAT_TAMU' => $faker->address,
                'NOHP_TAMU' => $faker->phoneNumber,
                'TGLKUNJUNGAN_TAMU' => $faker->date('Y-m-d'),
                'FOTO_TAMU' => 'uploads/foto_tamu/default.png',
                'JKL_TAMU' => $jklTamu,
                'JKP_TAMU' => $jkpTamu,
            ];
        }

        // Insert data ke database
        $this->db->table('bukutamu')->insertBatch($data);
    }
}
