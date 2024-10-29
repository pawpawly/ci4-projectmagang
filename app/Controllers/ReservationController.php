<?php

namespace App\Controllers;

use App\Models\ReservasiModel;
use CodeIgniter\Controller;

class ReservationController extends Controller
{
    protected $reservasiModel;

    public function __construct()
    {
        $this->reservasiModel = new ReservasiModel(); // Panggil model
    }

    public function index()
    {
        // Kirim data title ke view
        $data = [
            'title' => 'Jadwal'
        ];

        return view('schedule', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'nama_reservasi' => 'required',
            'instansi_reservasi' => 'required',
            'email_reservasi' => 'required|valid_email',
            'telepon_reservasi' => 'required',
            'jmlpengunjung_reservasi' => 'required|integer',
            'tanggal_reservasi' => 'required|valid_date[Y-m-d]',
        ]);
    
        // Validasi input
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Semua field wajib diisi!',
                'errors' => $validation->getErrors()
            ]);
        }
    
        // Ambil data dari form
        $data = [
            'NAMA_RESERVASI' => $this->request->getPost('nama_reservasi'),
            'INSTANSI_RESERVASI' => $this->request->getPost('instansi_reservasi'),
            'EMAIL_RESERVASI' => $this->request->getPost('email_reservasi'),
            'TELEPON_RESERVASI' => $this->request->getPost('telepon_reservasi'),
            'JMLPENGUNJUNG_RESERVASI' => $this->request->getPost('jmlpengunjung_reservasi'),
            'KEGIATAN_RESERVASI' => $this->request->getPost('kegiatan_reservasi'),
            'TANGGAL_RESERVASI' => $this->request->getPost('tanggal_reservasi'),
            'STATUS_RESERVASI' => 'pending',
        ];
    
        // Simpan data ke database
        $this->reservasiModel->insert($data);
    
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Reservasi berhasil disimpan!'
        ]);
    }
}    