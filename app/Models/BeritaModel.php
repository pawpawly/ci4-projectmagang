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

    /**
     * Mendapatkan semua berita beserta penyiar, diurutkan berdasarkan tanggal.
     *
     * @param int|null $limit Jumlah berita yang ingin diambil (opsional).
     * @return array Daftar berita.
     */
    public function getBeritaWithUser($limit = null)
    {
        $builder = $this->db->table($this->table)
            ->select('berita.*, berita.PENYIAR_BERITA AS NAMA_USER')
            ->orderBy('TANGGAL_BERITA', 'DESC'); // Urutkan dari berita terbaru

        if ($limit !== null) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }
}
