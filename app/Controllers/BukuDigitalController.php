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
    
        $this->bukuDigitalModel->select('*'); // Mulai query buku digital
    
        if ($keyword) {
            $this->bukuDigitalModel->like('JUDUL_BUKU', $keyword);
        }
    
        $bukudigital = $this->bukuDigitalModel->paginate(8); // Tambahkan paginate
        $pager = $this->bukuDigitalModel->pager;
    
        return view('bukudigital/index', [
            'bukudigital' => $bukudigital,
            'pager' => $pager,
            'keyword' => $keyword,
            'title' => 'Daftar E-Book'
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
        $buku = $this->bukuDigitalModel->find($id);
    
        if (!$buku) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak ditemukan.');
        }
    
        $filePath = FCPATH . 'uploads/bukudigital/pdf/' . $buku['PRODUK_BUKU'];
        if (!file_exists($filePath)) {
            echo "File PDF tidak ditemukan: " . $filePath;
            exit;
        }
        
    
        $data = [
            'title' => $buku['JUDUL_BUKU'], // Judul buku untuk tag <title>
            'pdfPath' => base_url('uploads/bukudigital/pdf/' . $buku['PRODUK_BUKU']), // Jalur PDF
        ];        
    
        return view('bukudigital/flipbook', $data);
    }
    
}
