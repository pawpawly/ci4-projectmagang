<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservasiModel extends Model
{
    protected $table = 'reservasi'; // Nama tabel
    protected $primaryKey = 'ID_RESERVASI'; // Primary key

    // Kolom yang dapat diisi secara massal
        protected $allowedFields = [
            'NAMA_RESERVASI',
            'INSTANSI_RESERVASI',
            'EMAIL_RESERVASI',
            'TELEPON_RESERVASI',
            'KEGIATAN_RESERVASI',
            'JMLPENGUNJUNG_RESERVASI',
            'TANGGAL_RESERVASI',
            'STATUS_RESERVASI',
            'SURAT_RESERVASI'
        ];
        public function getReservationsByMonth($month, $year)
{
                return $this->select("DATE_FORMAT(tanggal_reservasi, '%Y-%m-%d') AS tanggal_reservasi, instansi_reservasi, id_reservasi AS id")
            ->where('MONTH(tanggal_reservasi)', $month)
            ->where('YEAR(tanggal_reservasi)', $year)
            ->findAll();

}
}
