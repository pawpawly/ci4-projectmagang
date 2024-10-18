<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'ID_BERITA';
    protected $allowedFields = [
        'USERNAME', 'NAMA_BERITA', 'DESKRIPSI_BERITA', 'SUMBER_BERITA', 
        'TANGGAL_BERITA', 'FOTO_BERITA'
    ];

    public function getBeritaWithUser()
    {
        return $this->db->table($this->table)
            ->select('berita.*, user.NAMA_USER')
            ->join('user', 'user.USERNAME = berita.USERNAME')
            ->get()
            ->getResultArray();
    }
}
