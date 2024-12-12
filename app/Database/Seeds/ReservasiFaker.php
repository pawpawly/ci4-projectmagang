<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ReservasiFaker extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID'); // Menggunakan bahasa Indonesia

        $data = [];

        for ($i = 0; $i < 600; $i++) {
            $data[] = [
                'NAMA_RESERVASI' => $faker->name,
                'INSTANSI_RESERVASI' => $faker->company,
                'EMAIL_RESERVASI' => $faker->email,
                'TELEPON_RESERVASI' => $faker->phoneNumber,
                'KEGIATAN_RESERVASI' => $faker->sentence,
                'JMLPENGUNJUNG_RESERVASI' => $faker->numberBetween(1, 999),
                'TANGGAL_RESERVASI' => $faker->date('Y-m-d'),
                'STATUS_RESERVASI' => 'Pending',
                'SURAT_RESERVASI' => null,
            ];
        }

        // Insert data ke database
        $this->db->table('reservasi')->insertBatch($data);
    }
}