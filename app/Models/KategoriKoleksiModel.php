<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriKoleksiModel extends Model
{
    protected $table = 'kategori_koleksi';
    protected $primaryKey = 'ID_KKOLEKSI';
    protected $allowedFields = ['KATEGORI_KKOLEKSI', 'DESKRIPSI_KKOLEKSI'];

    public function getAllCategories()
    {
        return $this->findAll();
    }

    public function getCategoryById($id)
    {
        return $this->where('ID_KKOLEKSI', $id)->first();
    }
}
