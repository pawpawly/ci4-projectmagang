<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class KategoriKoleksiFaker extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID'); // Menggunakan bahasa Indonesia

        $data = [];

        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'KATEGORI_KKOLEKSI' => $faker->words(2, true),
                'DESKRIPSI_KKOLEKSI' => $faker->sentence,
            ];
        }

        // Insert data ke database
        $this->db->table('kategori_koleksi')->insertBatch($data);
    }
}