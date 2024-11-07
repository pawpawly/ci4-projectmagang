<?php

namespace App\Models;

use CodeIgniter\Model;

class SaranModel extends Model
{
    protected $table = 'saran';
    protected $primaryKey = 'ID_SARAN';
    protected $allowedFields = [
        'NAMA_SARAN',
        'EMAIL_SARAN',
        'KOMENTAR_SARAN',
        'TANGGAL_SARAN' // Menambahkan field TANGGAL_SARAN
    ];
}
