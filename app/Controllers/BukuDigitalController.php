<?php

namespace App\Controllers;

use App\Models\BukuDigitalModel;

class BukuDigitalController extends BaseController
{
    protected $bukuDigitalModel;

    public function __construct()
    {
        $this->bukuDigitalModel = new BukuDigitalModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $bukudigital = $keyword
            ? $this->bukuDigitalModel->like('JUDUL_BUKU', $keyword)->findAll(8)
            : $this->bukuDigitalModel->findAll(8);

            return view('bukudigital/index', [
                'bukudigital' => $bukudigital,
                'keyword' => $keyword,
                'title' => 'Daftar E-Book' // Tambahkan title di sini
            ]);
            
    }

    public function detail($id)
    {
        $buku = $this->bukuDigitalModel->find($id);

        if (!$buku) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak ditemukan.');
        }

        // Ambil 4 e-book random selain e-book yang sedang ditampilkan
        $relatedBooks = $this->bukuDigitalModel
            ->where('ID_BUKU !=', $id)
            ->orderBy('RAND()')
            ->findAll(4);

            return view('bukudigital/detail', [
                'buku' => $buku,
                'relatedBooks' => $relatedBooks,
                'title' => $buku['JUDUL_BUKU'] // Gunakan judul buku sebagai title
            ]);
            
    }
    public function flipbook($id)
    {
        // Cari buku berdasarkan ID
        $buku = $this->bukuDigitalModel->find($id);
    
        if (!$buku || !isset($buku['PRODUK_BUKU'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File PDF tidak ditemukan.');
        }
    
        // Validasi apakah file benar-benar ada
        $pathToFile = FCPATH . 'uploads/bukudigital/pdf/' . $buku['PRODUK_BUKU']; // Lokasi fisik file
        if (!file_exists($pathToFile)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File PDF tidak ditemukan di server.');
        }
    
        // Kirim data ke view flipbook
        return view('bukudigital/flipbook', [
            'pdf_file' => base_url('uploads/bukudigital/pdf/' . $buku['PRODUK_BUKU']),
            'title' => $buku['JUDUL_BUKU']
        ]);
    }
    
    
    
    

}
