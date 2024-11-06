<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuTamuModel extends Model
{
    protected $table = 'bukutamu'; // Nama tabel
    protected $primaryKey = 'ID_TAMU'; // Primary Key

    // Kolom yang diizinkan untuk diisi secara massal
    protected $allowedFields = [
        'NAMA_TAMU', 
        'TIPE_TAMU', 
        'ALAMAT_TAMU', 
        'NOHP_TAMU', 
        'TGLKUNJUNGAN_TAMU', 
        'JKL_TAMU', 
        'JKP_TAMU', 
    ];

    protected $useTimestamps = false; // Nonaktifkan fitur timestamps
}
