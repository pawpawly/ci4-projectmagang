<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'ID_BERITA';
    protected $allowedFields = [
        'PENYIAR_BERITA', 'NAMA_BERITA', 'DESKRIPSI_BERITA', 
        'SUMBER_BERITA', 'TANGGAL_BERITA', 'FOTO_BERITA'
    ];

    // Metode untuk mendapatkan semua berita beserta nama penyiar
    public function getBeritaWithUser()
    {
        return $this->db->table($this->table)
            ->select('berita.*, berita.PENYIAR_BERITA AS NAMA_USER')
            ->get()
            ->getResultArray();
    }
}
