<?php

namespace App\Models;

use CodeIgniter\Model;

class KoleksiModel extends Model
{
    protected $table = 'koleksi';
    protected $primaryKey = 'ID_KOLEKSI';
    protected $allowedFields = [
        'ID_KKOLEKSI', 'USERNAME', 'NAMA_KOLEKSI', 
        'DESKRIPSI_KOLEKSI', 'FOTO_KOLEKSI'
    ];

    public function getKoleksiWithKategori()
    {
        return $this->select('koleksi.*, kategori_koleksi.KATEGORI_KKOLEKSI')
                    ->join('kategori_koleksi', 'kategori_koleksi.ID_KKOLEKSI = koleksi.ID_KKOLEKSI')
                    ->findAll();
    }
}
