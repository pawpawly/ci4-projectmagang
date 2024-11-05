<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuDigitalModel extends Model
{
    protected $table = 'bukudigital';
    protected $primaryKey = 'ID_BUKU';
    protected $allowedFields = [
        'JUDUL_BUKU', 'PENULIS_BUKU', 'TAHUN_BUKU', 'SINOPSIS_BUKU', 'SAMPUL_BUKU', 'PRODUK_BUKU'
    ];
    

    public $useTimestamps = false;
}