<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class EventFaker extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');

        $db = \Config\Database::connect();
        $kategoriEvent = $db->table('kategori_event')->select('ID_KEVENT')->get()->getResultArray();

        if (empty($kategoriEvent)) {
            throw new \Exception('Tabel kategori_event tidak memiliki data.');
        }

        // Konversi data ID_KEVENT ke array sederhana
        $idKeventList = array_column($kategoriEvent, 'ID_KEVENT');

        $data = [];

        for ($i = 0; $i < 7; $i++) {
            $data[] = [
                'NAMA_EVENT' => $faker->sentence(3),
                'ID_KEVENT' => $faker->randomElement($idKeventList),
                'TANGGAL_EVENT' => $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
                'JAM_EVENT' => $faker->time('H:i:s'),
                'FOTO_EVENT' => null,
                'DEKSRIPSI_EVENT' => $faker->paragraph,
            ];
        }

        $this->db->table('event')->insertBatch($data);
    }
}
