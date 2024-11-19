<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuTamuModel extends Model
{
    protected $table = 'bukutamu';  
    protected $primaryKey = 'ID_TAMU';

    protected $allowedFields = [
        'NAMA_TAMU', 
        'TIPE_TAMU', 
        'ALAMAT_TAMU', 
        'NOHP_TAMU', 
        'TGLKUNJUNGAN_TAMU', 
        'FOTO_TAMU',
        'JKL_TAMU', 
        'JKP_TAMU',
    ];

    protected $useTimestamps = false;
}
