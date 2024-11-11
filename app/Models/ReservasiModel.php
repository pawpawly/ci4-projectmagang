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
        
}
