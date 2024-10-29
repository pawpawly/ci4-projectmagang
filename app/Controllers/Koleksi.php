<?php

namespace App\Controllers;

use App\Models\KoleksiModel;
use App\Models\KategoriKoleksiModel;

class Koleksi extends BaseController
{
    protected $koleksiModel;
    protected $kategoriKoleksiModel;

    public function __construct()
    {
        helper('text');  // Muat helper text di sini
        $this->koleksiModel = new KoleksiModel();
        $this->kategoriKoleksiModel = new KategoriKoleksiModel();
    }

    public function index()
    {
        $kategori = $this->kategoriKoleksiModel->findAll();
        $koleksi = $this->koleksiModel->paginate(8);
        $pager = $this->koleksiModel->pager;
    
        return view('koleksi/index', [
            'title' => 'Daftar Koleksi',  // Pastikan title dikirim
            'kategori' => $kategori,
            'koleksi' => $koleksi,
            'pager' => $pager,
        ]);
    }
    
    public function detail($id)
    {
        // Ambil data koleksi beserta kategorinya
        $koleksi = $this->koleksiModel
            ->select('koleksi.*, kategori_koleksi.KATEGORI_KKOLEKSI')
            ->join('kategori_koleksi', 'kategori_koleksi.ID_KKOLEKSI = koleksi.ID_KKOLEKSI', 'left')
            ->where('koleksi.ID_KOLEKSI', $id)
            ->first();
    
        if (!$koleksi) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Koleksi dengan ID $id tidak ditemukan.");
        }
    
        // Ambil koleksi terkait dari kategori yang sama
        $relatedKoleksi = $this->koleksiModel
            ->where('ID_KKOLEKSI', $koleksi['ID_KKOLEKSI'])
            ->where('ID_KOLEKSI !=', $id)
            ->limit(4)
            ->findAll();
    
        return view('koleksi/detail', [
            'title' => $koleksi['NAMA_KOLEKSI'], 
            'koleksi' => $koleksi,
            'relatedKoleksi' => $relatedKoleksi,
        ]);
    }
    
    
}
