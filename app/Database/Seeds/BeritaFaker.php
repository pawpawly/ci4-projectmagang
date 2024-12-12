<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class BeritaFaker extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID'); // Menggunakan bahasa Indonesia

        $data = [];

        for ($i = 0; $i < 600; $i++) {
            $data[] = [
                'PENYIAR_BERITA' => $faker->name,
                'NAMA_BERITA' => $faker->sentence,
                'DESKRIPSI_BERITA' => $faker->paragraph,
                'SUMBER_BERITA' => $faker->url,
                'TANGGAL_BERITA' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                'FOTO_BERITA' => null,
            ];
        }

        // Insert data ke database
        $this->db->table('berita')->insertBatch($data);
    }
}