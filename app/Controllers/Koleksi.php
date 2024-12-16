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
        helper(['text', 'url']);  // Muat helper URL
        $this->koleksiModel = new KoleksiModel();
        $this->kategoriKoleksiModel = new KategoriKoleksiModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $kategoriId = $this->request->getVar('kategori');

        // Query untuk koleksi
        $this->koleksiModel->select('koleksi.*, kategori_koleksi.KATEGORI_KKOLEKSI')
            ->join('kategori_koleksi', 'kategori_koleksi.ID_KKOLEKSI = koleksi.ID_KKOLEKSI', 'left');

        if ($keyword) {
            $this->koleksiModel->like('NAMA_KOLEKSI', $keyword);
        }

        if ($kategoriId) {
            $this->koleksiModel->where('koleksi.ID_KKOLEKSI', $kategoriId);
        }

        $kategori = $this->kategoriKoleksiModel->findAll();
        $koleksi = $this->koleksiModel->paginate(8);
        $pager = $this->koleksiModel->pager;

        return view('koleksi/index', [
            'title' => 'Daftar Koleksi',
            'kategori' => $kategori,
            'koleksi' => $koleksi,
            'pager' => $pager,
            'keyword' => $keyword,
            'selectedKategori' => $kategoriId,
        ]);
    }

    public function detail($id)
    {
        $koleksi = $this->koleksiModel
            ->select('koleksi.*, kategori_koleksi.KATEGORI_KKOLEKSI')
            ->join('kategori_koleksi', 'kategori_koleksi.ID_KKOLEKSI = koleksi.ID_KKOLEKSI', 'left')
            ->where('koleksi.ID_KOLEKSI', $id)
            ->first();

        if (!$koleksi) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Koleksi dengan ID $id tidak ditemukan.");
        }

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
