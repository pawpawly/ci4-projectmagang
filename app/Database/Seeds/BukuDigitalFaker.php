<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class BukuDigitalFaker extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID'); // Menggunakan bahasa Indonesia

        $data = [];

        for ($i = 0; $i < 9; $i++) {
            $data[] = [
                'JUDUL_BUKU' => $faker->sentence,
                'PENULIS_BUKU' => $faker->name,
                'TAHUN_BUKU' => $faker->year('-30 years'), // Maksimal 30 tahun ke belakang
                'SINOPSIS_BUKU' => $faker->paragraph,
                'SAMPUL_BUKU' => null,
                'PRODUK_BUKU' => null,
            ];
        }

        // Insert data ke database
        $this->db->table('bukudigital')->insertBatch($data);
    }
}
