<?php

namespace App\Controllers;

use App\Models\BeritaModel;

class Berita extends BaseController
{
    protected $beritaModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel(); // Inisialisasi model berita
    }

    public function index()
    {
        // Tentukan jumlah item per halaman
        $perPage = 6;
    
        $data = [
            'title' => 'Daftar Berita',
            'berita' => $this->beritaModel->orderBy('TANGGAL_BERITA', 'DESC')->paginate($perPage, 'default'),
            'pager' => $this->beritaModel->pager, // Tambahkan pager
        ];
    
        return view('berita/index', $data);
    }

    
    public function detail($id_berita)
    {
        // Cari berita berdasarkan ID
        $berita = $this->beritaModel->where('ID_BERITA', $id_berita)->first();
    
        if (!$berita) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita tidak ditemukan');
        }
    
        // Ambil 3 berita terbaru kecuali berita yang sedang dibuka
        $latestPosts = $this->beritaModel
            ->where('ID_BERITA !=', $id_berita)
            ->orderBy('TANGGAL_BERITA', 'DESC')
            ->limit(3)
            ->findAll();
    
        $data = [
            'title' => $berita['NAMA_BERITA'],
            'berita' => $berita,
            'latestPosts' => $latestPosts
        ];
    
        return view('berita/detail', $data);
    }
}

