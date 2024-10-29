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
        $data = [
            'title' => 'Daftar Berita', // Tambahkan variabel title
            'berita' => $this->beritaModel->orderBy('TANGGAL_BERITA', 'DESC')->findAll()
        ];
    
        return view('berita/index', $data); // Kirim data ke view
    }
    
    public function detail($slug)
    {
        // Cari berita berdasarkan slug
        $berita = $this->beritaModel->where('NAMA_BERITA', $slug)->first();
    
        if (!$berita) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita tidak ditemukan');
        }
    
        // Ambil 3 berita terbaru kecuali berita yang sedang dibuka
        $latestPosts = $this->beritaModel
            ->where('NAMA_BERITA !=', $slug)
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
