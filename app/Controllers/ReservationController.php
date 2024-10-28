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
        // Validasi input
        if (!$this->validate([
            'nama_reservasi' => 'required',
            'instansi_reservasi' => 'required',
            'email_reservasi' => 'required|valid_email',
            'telepon_reservasi' => 'required',
            'jmlpengunjung_reservasi' => 'required|integer',
            'tanggal_reservasi' => 'required|valid_date[Y-m-d]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        // Ambil data dari request
        $data = [
            'NAMA_RESERVASI' => $this->request->getPost('nama_reservasi'),
            'INSTANSI_RESERVASI' => $this->request->getPost('instansi_reservasi'),
            'EMAIL_RESERVASI' => $this->request->getPost('email_reservasi'),
            'TELEPON_RESERVASI' => $this->request->getPost('telepon_reservasi'),
            'JMLPENGUNJUNG_RESERVASI' => $this->request->getPost('jmlpengunjung_reservasi'),
            'KEGIATAN_RESERVASI' => $this->request->getPost('kegiatan_reservasi'),
            'TANGGAL_RESERVASI' => $this->request->getPost('tanggal_reservasi'),
            'STATUS_RESERVASI' => 'pending'
        ];
    
        // Simpan data ke database
        $this->reservasiModel->insert($data);
    
        // Redirect dengan pesan sukses
        return redirect()->to('/schedule')->with('success', 'Reservasi berhasil disimpan.');
    }
}    