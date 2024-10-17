<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use CodeIgniter\Controller;

class BeritaController extends Controller
{
    protected $beritaModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        helper('url');  // Menggunakan helper URL
        helper('month'); 
    }

public function index()
{
    $data['berita'] = $this->beritaModel->getBeritaWithUser();
    return view('superadmin/berita/manage', $data);
}

    public function add()
    {
        return view('superadmin/berita/add_berita');
    }

    public function save()
    {
        $data = [
            'USERNAME' => session()->get('username'),
            'NAMA_BERITA' => $this->request->getPost('nama_berita'),
            'DESKRIPSI_BERITA' => $this->request->getPost('deskripsi_berita'),
            'SUMBER_BERITA' => $this->request->getPost('sumber_berita'),
            'TANGGAL_BERITA' => date('Y-m-d'),  // Tanggal otomatis
        ];
    
        // Upload foto jika ada
        $foto = $this->request->getFile('foto_berita');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/berita/', $fotoName);
            $data['FOTO_BERITA'] = $fotoName;
        }
    
        $this->beritaModel->insert($data);
        return redirect()->to('/berita/manage')->with('message', 'Berita berhasil ditambahkan.');
    }

public function edit($id_berita)
{
    $berita = $this->beritaModel->find($id_berita);

    if (!$berita) {
        return redirect()->to('/berita/manage')->with('error', 'Berita tidak ditemukan!');
    }

    $data = [
        'berita' => $berita
    ];

    return view('superadmin/berita/edit_berita', $data);
}

public function update()
{
    $id_berita = $this->request->getPost('id_berita');

    $data = [
        'NAMA_BERITA' => $this->request->getPost('nama_berita'),
        'DESKRIPSI_BERITA' => $this->request->getPost('deskripsi_berita'),
        'SUMBER_BERITA' => $this->request->getPost('sumber_berita'),
        'TANGGAL_BERITA' => date('Y-m-d'),  // Tanggal otomatis saat update
    ];

    // Upload foto jika ada
    $foto = $this->request->getFile('foto_berita');
    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        $fotoLama = $this->beritaModel->find($id_berita)['FOTO_BERITA'];
        if (is_file(FCPATH . 'uploads/berita/' . $fotoLama)) {
            unlink(FCPATH . 'uploads/berita/' . $fotoLama);
        }

        $fotoName = $foto->getRandomName();
        $foto->move(FCPATH . 'uploads/berita/', $fotoName);
        $data['FOTO_BERITA'] = $fotoName;
    }

    $this->beritaModel->update($id_berita, $data);
    return redirect()->to('/berita/manage')->with('message', 'Berita berhasil diperbarui.');
}
}
