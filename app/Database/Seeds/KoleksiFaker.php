<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class KoleksiFaker extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID'); // Menggunakan bahasa Indonesia

        // Ambil data ID_KKOLEKSI dari tabel kategori_koleksi
        $db = \Config\Database::connect();
        $kategoriKoleksi = $db->table('kategori_koleksi')->select('ID_KKOLEKSI')->get()->getResultArray();

        if (empty($kategoriKoleksi)) {
            throw new \Exception('Tabel kategori_koleksi tidak memiliki data.');
        }

        // Konversi data ID_KKOLEKSI ke array sederhana
        $idKkoleksiList = array_column($kategoriKoleksi, 'ID_KKOLEKSI');

        $data = [];

        for ($i = 0; $i < 60; $i++) {
            $data[] = [
                'ID_KKOLEKSI' => $faker->randomElement($idKkoleksiList), // Pilih secara acak dari ID_KKOLEKSI yang ada
                'USERNAME' => null,
                'NAMA_KOLEKSI' => $faker->word,
                'DESKRIPSI_KOLEKSI' => $faker->sentence,
                'FOTO_KOLEKSI' => null,
            ];
        }

        // Insert data ke database
        $this->db->table('koleksi')->insertBatch($data);
    }
}
